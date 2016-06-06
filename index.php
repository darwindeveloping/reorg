<html>
<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <script type="text/javascript" charset="utf-8" src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="http://cdn.datatables.net/buttons/1.2.1/js/buttons.colVis.min.js"></script>
         <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
    THEAD{
        background-color:silver;
    }
    THEAD TH{
        border-left:1px solid silver;
    }
    td.details-control {
        background: url('images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('images/details_close.png') no-repeat center center;
    }
</style>
<body>

<h1>Open Payment Data</h1>

<table id="dataTable" class="stripe cell-border" cellspacing="0" width="100%">
    <thead style="background-color:silver;">
        <tr>
            <th></th>
            <th colspan="5">Physician Info</th>
            <th colspan="2">Payment Information</th>
            <th></th>
            <th colspan="2">Associated Covered  Drugs or Biological</th>
            <th></th>
        </tr>
        <tr>
            <th>Record ID</th>
            <th>Name</th>
            <th>Primary Type</th>
            <th>Specialy</th>
            <th>License State</th>
            <th>Address</th>
            <th>Total Amount</th>
            <th>Date Of Payment</th>
            <th>Name of Associated Covered Device </th>
            <th>Name</th>
            <th>NDC</th>
            <th></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</body>
<script>
    var data = {
        init:function(){
            this.mTable= $( '#dataTable' );
            this.loadData();
        },
        runJob:function(){
            $.get('console/job.php',
                function( data ){
                    console.log( data );
                });
        },
        loadData:function(){
             if ($.fn.DataTable.isDataTable(this.mTable.selector)) {
                this.mTable.DataTable().clear().destroy();
             }
            this.dtable = this.mTable.DataTable({
                dom: 'lBfrtip',
                lengthMenu: [
                    [ 100, 200, 500, -1 ],
                    [ '100 rows', '200 rows', '500 rows', 'Show all' ]
                ],
                buttons: [
                    {
                        extend:'excel',
                        text: 'Export To Excel',
                        title:'export'
                    },
                    {
                        extend:'colvis',
                        columns:[2,3,4,5,6, 7, 8, 9, 10],
                        collectionLayout: 'fixed two-column'
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "json/json.php",
                    "type": 'POST'
                },
                "columns": [
                    {
                        'data': "record_id",
                        "orderable":false

                    },
                    {
                        'data': null,
                        "orderable":false,
                        'render':function( row ){
                            return row.physician_first_name+' '+row.physician_middle_name+' '+row.physician_last_name;
                        }
                    },
                    {
                        'data':'physician_primary_type',
                        'orderable':false
                    },
                    {
                        'data':'physician_specialty',
                        'orderable':false
                    },
                    {
                        'data':'physician_license_state_code1',
                        'orderable':false,
                        'render':function( code, type, row ){
                            var codes = code;
                            if( row.physician_license_state_code2.length > 0 ){
                                codes +=', '+row.physician_license_state_code2;
                            }
                            if( row.physician_license_state_code3.length > 0 ){
                                codes +=', '+row.physician_license_state_code3;
                            }
                            if( row.physician_license_state_code4.length > 0 ){
                                codes +=', '+row.physician_license_state_code4;
                            }
                            if( row.physician_license_state_code5.length > 0 ){
                                codes +=', '+row.physician_license_state_code5;
                            }

                            return codes;
                        }
                    },
                    {
                        'data':'recipient_primary_business_street_address_line1',
                        'orderable':false,
                        'render':function( address, type, row ){
                            var d = address;

                            if( row.recipient_primary_business_street_address_line2.length > 0 ){
                                d += ' '+row.recipient_primary_business_street_address_line2;
                            }
                            d += row.recipient_city+', '+row.recipient_state+', '+row.recipient_zip_code;

                            return d;
                        }
                    },
                    {
                        'data': 'total_amount_of_payment_usdollars',
                        "orderable":      false,
                        'render':function( amount ){
                            return '$'+amount;
                        }
                    },
                    {
                        'data':'date_of_payment',
                        "orderable":      false,
                        'render':function( dates ){
                            var inputs = dates.split( ' ' );
                            var d = inputs[ 0].split( '-');
                            var t = inputs[ 1].split( ':');
//                            var td = new Date( d[ 0 ], d[1], d[2], t[ 0 ],t[1], t[2]  );

                            return d[1]+'/'+d[2]+'/'+d[0];
                        }
                    },
                    {
                      'data':'name_of_associated_covered_device_or_medical_supply1',
                        'orderable':false,
                        'render':function( device, type, row ){
                            var codes = device;
                            if( row.name_of_associated_covered_device_or_medical_supply2.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_device_or_medical_supply2;
                            }
                            if( row.name_of_associated_covered_device_or_medical_supply3.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_device_or_medical_supply3;
                            }
                            if( row.name_of_associated_covered_device_or_medical_supply4.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_device_or_medical_supply4;
                            }
                            if( row.name_of_associated_covered_device_or_medical_supply4.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_device_or_medical_supply4;
                            }

                            return codes;
                        }
                    },
                    {
                        'data':'name_of_associated_covered_drug_or_biological1',
                        'orderable':false,
                        'render':function( name, type, row ){
                            var codes = name;
                            if( row.name_of_associated_covered_drug_or_biological2.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_drug_or_biological2;
                            }
                            if( row.name_of_associated_covered_drug_or_biological3.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_drug_or_biological3;
                            }
                            if( row.name_of_associated_covered_drug_or_biological4.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_drug_or_biological4;
                            }
                            if( row.name_of_associated_covered_drug_or_biological5.length > 0 ){
                                codes +=', '+row.name_of_associated_covered_drug_or_biological5;
                            }

                            return codes;
                        }
                    },
                    {
                        'data':'ndc_of_associated_covered_drug_or_biological1',
                        'orderable':false,
                        'render':function( name, type, row ){
                            var codes = name;
                            if( row.ndc_of_associated_covered_drug_or_biological2.length > 0 ){
                                codes +=', '+row.ndc_of_associated_covered_drug_or_biological2;
                            }
                            if( row.ndc_of_associated_covered_drug_or_biological3.length > 0 ){
                                codes +=', '+row.ndc_of_associated_covered_drug_or_biological3;
                            }
                            if( row.ndc_of_associated_covered_drug_or_biological4.length > 0 ){
                                codes +=', '+row.ndc_of_associated_covered_drug_or_biological4;
                            }
                            if( row.ndc_of_associated_covered_drug_or_biological5.length > 0 ){
                                codes +=', '+row.ndc_of_associated_covered_drug_or_biological5;
                            }

                            return codes;
                        }
                    },
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    }
                ],
                "columnDefs": [
                    {
                        "targets": [ 4, 8,9,10 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                // set the initial value
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
            var that = this;

            $('#dataTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = that.dtable.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( that.displayRowInfo(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        },
        displayRowInfo:function( row ){
            var result = '<div class="row">';
                    result += '<div class="col-sm-4">' +
                            '<h4>Payment Info:</h4>'+
                            '<i>Form of Payment: </i>'+row.form_of_payment_or_transfer_of_value+'<br/>'+
                            '<i>Nature of Payment: </i>'+row.nature_of_payment_or_transfer_of_value+'<br/>'+
                            '<i>Third Party Recipient Indicator: </i>'+row.third_party_payment_recipient_indicator+'<br/>'+
                            '<i>Number of Payments Included: </i>'+row.number_of_payments_included_in_total_amount+
                            '</div>';
                    result += '<div class="col-sm-4">' +
                              '<h4>Manufacturer or GPO Making Payment Info:</h4>'+
                                '<i>ID: </i>'+row.applicable_manufacturer_or_applicable_gpo_making_payment_id+'<br/>'+
                                '<i>Name: </i> '+row.applicable_manufacturer_or_applicable_gpo_making_payment_name+'<br/>'+
                                '<i>Submitting Name: </i>'+row.submitting_applicable_manufacturer_or_applicable_gpo_name+'<br/>'+
                                '<i>Country: </i>'+row.applicable_manufacturer_or_applicable_gpo_making_payment_country+'<br/>'+
                                '</div>';

                    var license = row.physician_license_state_code1;

                    if( row.physician_license_state_code2.length > 0 ){
                        license += ', '+row.physician_license_state_code2;
                    }
                    if( row.physician_license_state_code3.length > 0 ){
                        license += ', '+row.physician_license_state_code3;
                    }
                    if( row.physician_license_state_code4.length > 0 ){
                        license += ', '+row.physician_license_state_code4;
                    }
                    if( row.physician_license_state_code5.length > 0 ){
                        license += ', '+row.physician_license_state_code5;
                    }

                    result += '<div class="col-sm-4">' +
                                '<h4>Physician Info: </h4>'+
                                '<i>Specialty: </i>'+row.physician_specialty+'<br/>'+
                                '<i>Primary Type: </i>'+row.physician_primary_type+'<br/>'+
                                '<i>License States: </i>'+license+'<br/>'+
                                '<i>Ownership Indicator: </i>'+row.physician_ownership_indicator+'<br/>'+
                                '</div>';
            if( parseInt( row.teaching_hospital_id ) > 0 ){
                        result += '<div class="col-sm-4">' +
                                    '<h4>Teaching Hospital:</h4>'+
                                    '<i>ID: </i>'+row.teaching_hospital_id+'<br/>'+
                                    '<i>Name: </i>'+row.teaching_hospital_name+
                                    '</div>';
                    }
                    if( row.city_of_travel.length > 0 ){
                        result += '<div class="col-sm-4">' +
                                    '<h4>Travel Info:</h4> '+
                                    ' '+row.city_of_travel+', '+row.state_of_travel+'<br/>' +
                                       row.country_of_travel+
                                    '</div>';
                    }
                    if( row.recipient_primary_business_street_address_line1.length > 0 ){
                        result += '<div class="col-sm-4">' +
                                    '<h4>Recipient Address:</h4>'+
                                        row.recipient_primary_business_street_address_line1+' '+row.recipient_primary_business_street_address_line2+'<br/>'+
                                        row.recipient_city+', '+row.recipient_state+' '+row.recipient_zip_code+'<br/>'+
                                        row.recipient_country+
                                        '</div>';
                    }
                    var drug_biological = '';
                    if( row.name_of_associated_covered_drug_or_biological1.length > 0 ){
                        drug_biological += '<li>'.row.name_of_associated_covered_drug_or_biological1+'</li>';
                    }
                    if( row.name_of_associated_covered_drug_or_biological2.length > 0 ){
                        drug_biological += '<li>'.row.name_of_associated_covered_drug_or_biological2+'</li>';
                    }
                    if( row.name_of_associated_covered_drug_or_biological3.length > 0 ){
                        drug_biological += '<li>'.row.name_of_associated_covered_drug_or_biological3+'</li>';
                    }
                    if( row.name_of_associated_covered_drug_or_biological4.length > 0 ){
                        drug_biological += '<li>'.row.name_of_associated_covered_drug_or_biological4+'</li>';
                    }
                    if( row.name_of_associated_covered_drug_or_biological5.length > 0 ){
                        drug_biological += '<li>'.row.name_of_associated_covered_drug_or_biological5+'</li>';
                    }

                    if( drug_biological.length > 0 ){
                        result +=  '<div class="col-sm-4">' +
                                        '<h4>Name Of Associated Covered Drug or Biological</h4>'+
                                            drug_biological.length+
                                    '</div>';
                    }

            drug_biological = '';
            if( row.ndc_of_associated_covered_drug_or_biological1.length > 0 ){
                drug_biological += '<li>'.row.ndc_of_associated_covered_drug_or_biological1+'</li>';
            }
            if( row.ndc_of_associated_covered_drug_or_biological2.length > 0 ){
                drug_biological += '<li>'.row.ndc_of_associated_covered_drug_or_biological2+'</li>';
            }
            if( row.ndc_of_associated_covered_drug_or_biological3.length > 0 ){
                drug_biological += '<li>'.row.ndc_of_associated_covered_drug_or_biological3+'</li>';
            }
            if( row.ndc_of_associated_covered_drug_or_biological4.length > 0 ){
                drug_biological += '<li>'.row.ndc_of_associated_covered_drug_or_biological4+'</li>';
            }
            if( row.ndc_of_associated_covered_drug_or_biological5.length > 0 ){
                drug_biological += '<li>'.row.ndc_of_associated_covered_drug_or_biological5+'</li>';
            }

            if( drug_biological.length > 0 ){
                result +=  '<div class="col-sm-4">' +
                '<h4>NDC Of Associated Covered Drug or Biological</h4>'+
                drug_biological.length+
                '</div>';
            }

                    result+='</div>';
            return result;
        }
    };


    $( function(){
        data.init();
//        $('#dataTable').DataTable();
    });

    setInterval(data.runJob, 300000 );

</script>
