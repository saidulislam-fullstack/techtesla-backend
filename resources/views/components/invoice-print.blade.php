<div id="quotationSection">
    <div class="container-fluid">
        <!-- Header -->
        @php
        $warehouse = App\Models\Warehouse::first();
        @endphp

        @if($header)
        <div style="text-align: center; padding: 20px; color:#000;">
            <img id="logo" style="position: absolute; left: 20px;" src="{{ url('logo', $general_setting->site_logo) }}"
                alt="Logo" height="50">
            <h3 style="font-size: 28px;"><strong>{{ $general_setting->site_title }}</strong></h3>
            <p>Address: {{ $warehouse->name . ', ' . $warehouse->address }}<br>
                Phone: {{ $warehouse->phone }}, Email: {{ $warehouse->email }}</p>
            <div style="display: flex; justify-content: center; margin-top: 10px;">
                <h6 style="border: 1px dashed black; width: 38%; padding: 5px 0px; font-size: 18px;">
                    <strong>{{ $title }}</strong>
                </h6>
            </div>
        </div>
        @endif

        <!-- Dynamic Content -->
        {{ $slot }}

        @if($footer)
        <!-- Signature -->
        <div style="margin-top: 100px; display: flex; justify-content: space-between; color: #000;">
            <div>
                <p>______________________<br>Receiver's Signature<br>Name: <br>Designation:<br>Mobile: </p>
            </div>
            <div>
                <p>______________________<br>Authorized Signature<br>Name: <br>Designation: <br>Mobile: </p>
            </div>
        </div>
        @endif

        <!-- Print Button -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-primary" id="printBtn" onclick="printQuotation()">Print</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        #printBtn {
            display: none;
        }

        body {
            background-color: #fff;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function printQuotation() {
        const printContent = document.getElementById('quotationSection').innerHTML;
        const originalContent = document.body.innerHTML;
        const originalTitle = document.title;
        
        // Set dynamic filename using document.title
        document.title = "{{ $filename }}";

        document.body.innerHTML = printContent;

        setTimeout(() => {
            // window.print();
            // document.body.innerHTML = originalContent;
            // document.title = originalTitle;
            // location.reload();
        }, 500);
    }
</script>
@endpush