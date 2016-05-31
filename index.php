<html>
<head>
    <link rel="stylesheet" src="http://cdn.datatables.net/1.10.6/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
</head>
<body>
<table id="dataTable" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th></th>
            <th colspan="4">Physician Name</th>
            <th colspan="2">Teaching Hospital Info</th>
            <th colspan="4">Physician Info</th>
            <th colspan="20"></th>

        </tr>
        <tr>
            <th>Record ID</th>
            <th>Suffix</th>
            <th>First</th>
            <th>M</th>
            <th>Last</th>
            <th> ID</th>
            <th>Name</th>
            <th>Specialty</th>
            <th>Primary Type</th>
            <th>Profile Id</th>
            <th>Ownership Indicator</th>
            <th>Physician License State Code 1</th>
            <th>Physician License State Code 2</th>
            <th>Physician License State Code 3</th>
            <th>Physician License State Code 4</th>
            <th>Physician License State Code 5</th>
            <th>Total Amount Of Payment US Dollars</th>
            <th>Number Of Payments Included In Total Amount</th>
            <th>Date Of Payment</th>
            <th>Form Of Payment Or Transfer Of Value</th>
            <th>Charity Indicator</th>
            <th>Payment Publication Date</th>
            <th>City Of Travel</th>
            <th>State Of Travel</th>
            <th>Covered Recipient Type</th>
            <th>Recipient Primary Business Street Address Line1</th>
            <th>Recipient Primary Business Street Address Line2</th>
            <th>Recipient City</th>
            <th>Recipient State</th>
            <th>Recipient Zip Code</th>
            <th>Recipient Country</th>

            <th></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <th>Dr</th>
            <th>Darwin</th>
            <th>M</th>
            <th>Salgado</th>
            <th>3</th>
            <th>Methodist Hospital</th>
        </tr>
    </tbody>
</table>
</body>
<script>
    var data = {
        init:function(){
            this.mTable= $( '#dataTable' );
            this.loadData();

        },
        loadData:function(){
             if ($.fn.DataTable.isDataTable(this.mTable.selector)) {
             this.mTable.DataTable().clear().destroy();
             }
            this.dtable = this.mTable.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "http://reorg.local/json/json.php",
                    "type": 'POST'
                },
                "columns": [
                    {'data': "record_id"},
                    {'data': "physician_name_suffix"},
                    {'data': 'physician_first_name'},
                    {'data':'physician_middle_name'},
                    {'data': "physician_last_name"},
                    {'data':'teaching_hospital_id'},
                    {'data':'teaching_hospital_name'},
                    {'data': "physician_specialty"},
                    {'data': "physician_primary_type"},
                    {'data': 'physician_profile_id'},
                    {'data':'physician_ownership_indicator'},
                    {'data': "physician_license_state_code1"},
                    {'data':'physician_license_state_code2'},
                    {'data':'physician_license_state_code3'},
                    {'data': "physician_license_state_code4"},
                    {'data': "physician_license_state_code5"},
                    {'data': 'total_amount_of_payment_usdollars'},
                    {'data':'date_of_payment'},
                    {'data': "form_of_payment_or_transfer_of_value"},
                    {'data':'charity_indicator'},
                    {'data':'payment_publication_date'},
                    {'data':'city_of_travel'},
                    {'data':'state_of_travel'},
                    {'data':'country_of_travel'},
                    {'data':'covered_recipient_type'},
                    {'data':'recipient_primary_business_street_address_line1'},
                    {'data':'recipient_primary_business_street_address_line2'},
                    {'data':'recipient_city'},
                    {'data':'recipient_state'},
                    {'data':'recipient_zip_code'},
                    {'data':'recipient_country'}
                ],

                "order": [
                    [0, "asc"]
                ],
                "lengthMenu": [
                    [10, 20, 30, -1],
                    [10, 20, 30, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
                "language": {
                    "lengthMenu": "_MENU_ records",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                }
            });

            /*
             var that = this;
             $(document).on( 'init.dt', function ( e, settings ) {
             that.checkAllFields( $( '#checkAllManufacturers' ) );
             } );

             $(document).on( 'draw.dt', function ( e, settings ) {
             that.checkAllFields( $( '#checkAllManufacturers' ) );
             } );

             */
        }
    };


    $( function(){
        data.init();
//        $('#dataTable').DataTable();

    });
</script>
