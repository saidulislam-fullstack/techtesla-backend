<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use App\Models\Sale;
use App\Models\User;
use App\Models\Account;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\CustomField;
use App\Models\MailSetting;
use App\Mail\CustomerCreate;
use App\Mail\SupplierCreate;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Mail\CustomerDeposit;
use App\Models\ContactPerson;
use App\Models\CustomerGroup;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB as FacadesDB;

class CustomerController extends Controller
{
    use \App\Traits\CacheForget;
    use \App\Traits\MailInfo;

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_customer_all = Customer::with('customerGroup')->where('is_active', true)->get();
            $custom_fields = CustomField::where([
                ['belongs_to', 'customer'],
                ['is_table', true]
            ])->pluck('name');
            return view('backend.customer.index', compact('lims_customer_all', 'all_permission', 'custom_fields'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function clearDue(Request $request)
    {
        $lims_due_sale_data = Sale::select('id', 'warehouse_id', 'grand_total', 'paid_amount', 'payment_status')
            ->where([
                ['payment_status', '!=', 4],
                ['customer_id', $request->customer_id]
            ])->get();
        $total_paid_amount = $request->amount;
        foreach ($lims_due_sale_data as $key => $sale_data) {
            if ($total_paid_amount == 0)
                break;
            $due_amount = $sale_data->grand_total - $sale_data->paid_amount;
            $lims_cash_register_data =  CashRegister::select('id')
                ->where([
                    ['user_id', Auth::id()],
                    ['warehouse_id', $sale_data->warehouse_id],
                    ['status', 1]
                ])->first();
            if ($lims_cash_register_data)
                $cash_register_id = $lims_cash_register_data->id;
            else
                $cash_register_id = null;
            $account_data = Account::select('id')->where('is_default', 1)->first();
            if ($total_paid_amount >= $due_amount) {
                $paid_amount = $due_amount;
                $payment_status = 4;
            } else {
                $paid_amount = $total_paid_amount;
                $payment_status = 2;
            }
            Payment::create([
                'payment_reference' => 'spr-' . date("Ymd") . '-' . date("his"),
                'sale_id' => $sale_data->id,
                'user_id' => Auth::id(),
                'cash_register_id' => $cash_register_id,
                'account_id' => $account_data->id,
                'amount' => $paid_amount,
                'change' => 0,
                'paying_method' => 'Cash',
                'payment_note' => $request->note
            ]);
            $sale_data->paid_amount += $paid_amount;
            $sale_data->payment_status = $payment_status;
            $sale_data->save();
            $total_paid_amount -= $paid_amount;
        }
        return redirect()->back()->with('message', 'Due cleared successfully');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-add')) {
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $custom_fields = CustomField::where('belongs_to', 'customer')->get();
            return view('backend.customer.create', compact('lims_customer_group_all', 'custom_fields'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'phone_number' => [
        //         'max:255',
        //         Rule::unique('customers')->where(function ($query) {
        //             return $query->where('is_active', 1);
        //         }),
        //     ],
        // ]);
        // //validation for supplier if create both user and supplier
        // if (isset($request->both)) {
        //     $this->validate($request, [
        //         'company_name' => [
        //             'max:255',
        //             Rule::unique('suppliers')->where(function ($query) {
        //                 return $query->where('is_active', 1);
        //             }),
        //         ],
        //         'email' => [
        //             'max:255',
        //             Rule::unique('suppliers')->where(function ($query) {
        //                 return $query->where('is_active', 1);
        //             }),
        //         ],
        //     ]);
        // }
        // //validation for user if given user access
        // if (isset($request->user)) {
        //     $this->validate($request, [
        //         'name' => [
        //             'max:255',
        //             Rule::unique('users')->where(function ($query) {
        //                 return $query->where('is_deleted', false);
        //             }),
        //         ],
        //         'email' => [
        //             'email',
        //             'max:255',
        //             Rule::unique('users')->where(function ($query) {
        //                 return $query->where('is_deleted', false);
        //             }),
        //         ],
        //     ]);
        // }
        $customer_data = $request->all();
        //return $customer_data;
        $customer_data['is_active'] = true;
        $prefixMessage = 'Customer';
        if (isset($request->user)) {
            $customer_data['phone'] = $customer_data['phone_number'];
            $customer_data['role_id'] = 5;
            $customer_data['is_deleted'] = false;
            $customer_data['password'] = bcrypt($customer_data['password']);
            $user = User::create($customer_data);
            $customer_data['user_id'] = $user->id;
            $prefixMessage .= ', User';
        }
        $customer_data['name'] = $customer_data['customer_name'];
        if (isset($request->both)) {
            Supplier::create($customer_data);
            $prefixMessage .= ' and Supplier';
        }

        $fullMessage = $prefixMessage . ' created successfully!';
        $mail_setting = MailSetting::latest()->first();
        $message = $this->mailAction($customer_data, $mail_setting, $request, $fullMessage);

        // if($customer_data['email'] && $mail_setting) {
        //     $this->setMailInfo($mail_setting);
        //     try {
        //         Mail::to($customer_data['email'])->send(new CustomerCreate($customer_data));
        //         if(isset($request->both))
        //             Mail::to($customer_data['email'])->send(new SupplierCreate($customer_data));
        //         $message .= ' created successfully!';
        //     }
        //     catch(\Exception $e){
        //         $message .= ' created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        //     }
        // }
        // else
        //     $message .= ' created successfully!';

        $lims_customer_data = Customer::create($customer_data);

        // Insterting data into the contact persons table
        $contactPersons = $request->contact_persons;

        // Visiting Card Front
        $frontName = null;
        if ($request->hasFile('visiting_card_front')) {
            $frontExt = $request->file('visiting_card_front')->getClientOriginalExtension();
            $frontName = 'front_' . time() . '_' . uniqid() . '.' . $frontExt;

            $request->file('visiting_card_front')->move(
                public_path('images/visiting-cards'),
                $frontName
            );
        }

        // Visiting Card Back
        $backName = null;
        if ($request->hasFile('visiting_card_back')) {
            $backExt = $request->file('visiting_card_back')->getClientOriginalExtension();
            $backName = 'back_' . time() . '_' . uniqid() . '.' . $backExt;

            $request->file('visiting_card_back')->move(
                public_path('images/visiting-cards'),
                $backName
            );
        }

        foreach ($contactPersons as $person) {
            ContactPerson::create([
                'contactable_type' => 'App\Models\Customer',
                'contactable_id' => $lims_customer_data->id,
                'name' => $person['name'],
                'email' => $person['email'],
                'phone' => $person['phone'],
                'designation' => $person['designation'],
                'visiting_card_front' => isset($person['visiting_card_front']) && $person['visiting_card_front'] ? $person['visiting_card_front']->store('visiting-cards', 'public') : null,
                'visiting_card_back' => isset($person['visiting_card_back']) && $person['visiting_card_back'] ? $person['visiting_card_back']->store('visiting-cards', 'public') : null,
            ]);
        }


        //inserting data for custom fields
        $custom_field_data = [];
        $custom_fields = CustomField::where('belongs_to', 'customer')->select('name', 'type')->get();
        foreach ($custom_fields as $type => $custom_field) {
            $field_name = str_replace(' ', '_', strtolower($custom_field->name));
            if (isset($customer_data[$field_name])) {
                if ($custom_field->type == 'checkbox' || $custom_field->type == 'multi_select')
                    $custom_field_data[$field_name] = implode(",", $customer_data[$field_name]);
                else
                    $custom_field_data[$field_name] = $customer_data[$field_name];
            }
        }
        if (count($custom_field_data))
            DB::table('customers')->where('id', $lims_customer_data->id)->update($custom_field_data);
        $this->cacheForget('customer_list');
        $customerInfo['id'] = $lims_customer_data->id;
        $customerInfo['name'] = $lims_customer_data->name;
        $customerInfo['phone_number'] = $lims_customer_data->phone_number;
        if ($customer_data['pos'])
            return $customerInfo;
        else
            return redirect('customer')->with('create_message', $message);
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-edit')) {
            $lims_customer_data = Customer::find($id);
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            $custom_fields = CustomField::where('belongs_to', 'customer')->get();
            return view('backend.customer.edit', compact('lims_customer_data', 'lims_customer_group_all', 'custom_fields'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                Rule::unique('customers')->ignore($id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $lims_customer_data = Customer::find($id);

        if (isset($input['user'])) {
            $this->validate($request, [
                'name' => [
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
                'email' => [
                    'email',
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);

            $input['phone'] = $input['phone_number'];
            $input['role_id'] = 5;
            $input['is_active'] = true;
            $input['is_deleted'] = false;
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $input['user_id'] = $user->id;
            $message = 'Customer updated and user created successfully';
        } else {
            $message = 'Customer updated successfully';
        }

        $input['name'] = $input['customer_name'];
        $input['bin_number'] = $input['bin_no'];
        $lims_customer_data->update($input);



        /* --------------------------------------
            CONTACT PERSON UPDATE LOGIC
        --------------------------------------- */
        $customer = Customer::find($id);
        $oldIds = $customer->contactPersons()->pluck('id')->toArray();
        $submitted = $request->contact_persons ?? [];

        $newIds = [];

        foreach ($submitted as $person) {

            /* --------------------------------------
                IF EXISTING CONTACT PERSON
            --------------------------------------- */
            if (isset($person['id'])) {

                $cp = ContactPerson::find($person['id']);
                $newIds[] = $cp->id;

                // Upload front card
                if (isset($person['visiting_card_front']) && $person['visiting_card_front'] instanceof \Illuminate\Http\UploadedFile) {

                    // delete old file
                    if ($cp->visiting_card_front && Storage::disk('public')->exists($cp->visiting_card_front)) {
                        Storage::disk('public')->delete($cp->visiting_card_front);
                    }

                    $frontPath = $person['visiting_card_front']->store('visiting-cards', 'public');
                    $cp->visiting_card_front = $frontPath;
                }

                // Upload back card
                if (isset($person['visiting_card_back']) && $person['visiting_card_back'] instanceof \Illuminate\Http\UploadedFile) {

                    // delete old file
                    if ($cp->visiting_card_back && Storage::disk('public')->exists($cp->visiting_card_back)) {
                        Storage::disk('public')->delete($cp->visiting_card_back);
                    }

                    $backPath = $person['visiting_card_back']->store('visiting-cards', 'public');
                    $cp->visiting_card_back = $backPath;
                }

                // Save updated data
                $cp->update([
                    'name'        => $person['name'],
                    'email'       => $person['email'],
                    'phone'       => $person['phone'],
                    'designation' => $person['designation'],
                ]);
            }

            /* --------------------------------------
                NEW CONTACT PERSON
            --------------------------------------- */
            else {

                $frontPath = null;
                $backPath = null;

                if (isset($person['visiting_card_front']) && $person['visiting_card_front'] instanceof \Illuminate\Http\UploadedFile) {
                    $frontPath = $person['visiting_card_front']->store('visiting-cards', 'public');
                }

                if (isset($person['visiting_card_back']) && $person['visiting_card_back'] instanceof \Illuminate\Http\UploadedFile) {
                    $backPath = $person['visiting_card_back']->store('visiting-cards', 'public');
                }

                $new = ContactPerson::create([
                    'contactable_type'    => 'App\Models\Customer',
                    'contactable_id'      => $customer->id,
                    'name'                => $person['name'],
                    'email'               => $person['email'],
                    'phone'               => $person['phone'],
                    'designation'         => $person['designation'],
                    'visiting_card_front' => $frontPath,
                    'visiting_card_back'  => $backPath,
                ]);

                $newIds[] = $new->id;
            }
        }

        /* --------------------------------------
            DELETE REMOVED CONTACT PERSONS
        --------------------------------------- */
        $toDelete = array_diff($oldIds, $newIds);

        if (count($toDelete)) {

            $deleteItems = ContactPerson::whereIn('id', $toDelete)->get();

            // Delete files also
            foreach ($deleteItems as $d) {
                if ($d->visiting_card_front && Storage::disk('public')->exists($d->visiting_card_front)) {
                    Storage::disk('public')->delete($d->visiting_card_front);
                }
                if ($d->visiting_card_back && Storage::disk('public')->exists($d->visiting_card_back)) {
                    Storage::disk('public')->delete($d->visiting_card_back);
                }
            }

            ContactPerson::whereIn('id', $toDelete)->delete();
        }







        //update custom field data
        $custom_field_data = [];
        $custom_fields = CustomField::where('belongs_to', 'customer')->select('name', 'type')->get();
        foreach ($custom_fields as $type => $custom_field) {
            $field_name = str_replace(' ', '_', strtolower($custom_field->name));
            if (isset($input[$field_name])) {
                if ($custom_field->type == 'checkbox' || $custom_field->type == 'multi_select')
                    $custom_field_data[$field_name] = implode(",", $input[$field_name]);
                else
                    $custom_field_data[$field_name] = $input[$field_name];
            }
        }
        if (count($custom_field_data))
            DB::table('customers')->where('id', $lims_customer_data->id)->update($custom_field_data);
        $this->cacheForget('customer_list');

        return redirect('customer')->with('edit_message', $message);
    }

    public function importCustomer(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('customers-add')) {
            $upload = $request->file('file');
            $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
            if ($ext != 'csv')
                return redirect()->back()->with('not_permitted', 'Please upload a CSV file');
            $filename =  $upload->getClientOriginalName();
            $filePath = $upload->getRealPath();
            //open and read
            $file = fopen($filePath, 'r');
            $header = fgetcsv($file);
            $escapedHeader = [];
            //validate
            foreach ($header as $key => $value) {
                $lheader = strtolower($value);
                $escapedItem = preg_replace('/[^a-z]/', '', $lheader);
                array_push($escapedHeader, $escapedItem);
            }

            $mail_setting = MailSetting::latest()->first();

            //looping through othe columns
            while ($columns = fgetcsv($file)) {
                if ($columns[0] == "")
                    continue;
                foreach ($columns as $key => $value) {
                    $value = preg_replace('/\D/', '', $value);
                }
                $data = array_combine($escapedHeader, $columns);
                $lims_customer_group_data = CustomerGroup::where('name', $data['customergroup'])->first();
                $customer = Customer::firstOrNew(['name' => $data['name']]);
                $customer->customer_group_id = $lims_customer_group_data->id;
                $customer->name = $data['name'];
                $customer->company_name = $data['companyname'];
                $customer->email = $data['email'];
                $customer->phone_number = $data['phonenumber'];
                $customer->address = $data['address'];
                $customer->city = $data['city'];
                $customer->state = $data['state'];
                $customer->postal_code = $data['postalcode'];
                $customer->country = $data['country'];
                $customer->is_active = true;
                $customer->save();

                $message = $this->mailAction($data, $mail_setting, $request, 'Customer Imported Successfully');

                //    $mail_setting = MailSetting::latest()->first();
                //    if($data['email'] && $mail_setting) {
                //         $this->setMailInfo($mail_setting);
                //         try {
                //             Mail::to($data['email'])->send(new CustomerCreate($data));
                //         }
                //         catch(\Exception $e){
                //             $message = 'Customer imported successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
                //         }
                //     }

            }
            $this->cacheForget('customer_list');
            return redirect('customer')->with('import_message', $message);
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getDeposit($id)
    {
        $lims_deposit_list = Deposit::where('customer_id', $id)->get();
        $deposit_id = [];
        $deposits = [];
        foreach ($lims_deposit_list as $deposit) {
            $deposit_id[] = $deposit->id;
            $date[] = $deposit->created_at->toDateString() . ' ' . $deposit->created_at->toTimeString();
            $amount[] = $deposit->amount;
            $note[] = $deposit->note;
            $lims_user_data = User::find($deposit->user_id);
            $name[] = $lims_user_data->name;
            $email[] = $lims_user_data->email;
        }
        if (!empty($deposit_id)) {
            $deposits[] = $deposit_id;
            $deposits[] = $date;
            $deposits[] = $amount;
            $deposits[] = $note;
            $deposits[] = $name;
            $deposits[] = $email;
        }
        return $deposits;
    }

    public function addDeposit(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $lims_customer_data = Customer::find($data['customer_id']);
        $lims_customer_data->deposit += $data['amount'];
        $lims_customer_data->save();
        Deposit::create($data);
        $message = 'Data inserted successfully';
        $mail_setting = MailSetting::latest()->first();

        if ($lims_customer_data->email && $mail_setting) {
            $data['name'] = $lims_customer_data->name;
            $data['email'] = $lims_customer_data->email;
            $data['balance'] = $lims_customer_data->deposit - $lims_customer_data->expense;
            $data['currency'] = config('currency');
            $message = $this->mailAction($data, $mail_setting, $request);

            // $this->setMailInfo($mail_setting);
            // try {
            //     Mail::to($data['email'])->send(new CustomerDeposit($data));
            // }
            // catch(\Exception $e){
            //     $message = 'Data inserted successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            // }
        }
        return redirect('customer')->with('create_message', $message);
    }

    public function updateDeposit(Request $request)
    {
        $data = $request->all();
        $lims_deposit_data = Deposit::find($data['deposit_id']);
        $lims_customer_data = Customer::find($lims_deposit_data->customer_id);
        $amount_dif = $data['amount'] - $lims_deposit_data->amount;
        $lims_customer_data->deposit += $amount_dif;
        $lims_customer_data->save();
        $lims_deposit_data->update($data);
        return redirect('customer')->with('create_message', 'Data updated successfully');
    }

    public function deleteDeposit(Request $request)
    {
        $data = $request->all();
        $lims_deposit_data = Deposit::find($data['id']);
        $lims_customer_data = Customer::find($lims_deposit_data->customer_id);
        $lims_customer_data->deposit -= $lims_deposit_data->amount;
        $lims_customer_data->save();
        $lims_deposit_data->delete();
        return redirect('customer')->with('not_permitted', 'Data deleted successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $customer_id = $request['customerIdArray'];
        foreach ($customer_id as $id) {
            $lims_customer_data = Customer::find($id);
            $lims_customer_data->is_active = false;
            $lims_customer_data->save();
        }
        $this->cacheForget('customer_list');
        return 'Customer deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_customer_data = Customer::find($id);
        $lims_customer_data->is_active = false;
        $lims_customer_data->save();
        $this->cacheForget('customer_list');
        return redirect('customer')->with('not_permitted', 'Data deleted Successfully');
    }

    protected function mailAction($data, $mailSetting, $request, $customMessage = null)
    {
        $message = $customMessage ?? 'Data inserted successfully';
        if (!$mailSetting) {
            $message = 'Data inserted successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        } else if ($data['email'] && $mailSetting) {
            try {
                $this->setMailInfo($mailSetting);
                Mail::to($data['email'])->send(new CustomerCreate($data));
                if (isset($request->both))
                    Mail::to($data['email'])->send(new SupplierCreate($data));
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }
}
