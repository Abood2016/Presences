<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="{{csrf_token()}}" name="csrf-token" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend-assets/plugins/fontawesome-free/css/all.css')}}">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"  rel = "stylesheet">
    <title>سجل الحضور</title>

</head>

<body>
    <!-- Image and text -->
    <header>
        <nav class="navbar navbar-light" style="background-color: black;">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{asset('assets/images/logo.jpeg')}}" width="150" height="50" class="d-inline-block align-top"
                    alt="">
            </a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-white font-weight-bold" href="{{route('employee.index')}}">اضافة موظف <span
                            class="sr-only">(current)</span></a>
                </li>

            </ul>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="btn btn-sm btn-danger"><i class="fa fa-logout"></i>سجل خروج
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        </nav>
    </header>
    <main class="mt-4">

        <div class="container-fluid mt-4">
            <div class="form-group col-sm-12 row ">
                <div  class="col-sm-12 row" style="margin-right: 0.01em">
                    <span class="mr-5" style="font-size: 1.2em;font-weight: 600;margin-right: 4em!important;">
                        ابحث عن موظف
                    </span>
                    <form class="col-sm-12 row mt-4 mr-5" id="search_form" method="GET">
                     @csrf
                        <input type="text" name="test" value="test" style="display: none">
                        <label class="col-sm-3 mt-1">
                            <select name="employee_id" class="js-example-basic-single select form-control">
                                <option value=""></option>
                                @foreach($employees as $row)
                                <option class="text-right" value="{{$row->EMP_ID}}">{{$row->EMP_NAME}}</option>
                                @endforeach
                            </select>
                        </label>
                        <p class="col-sm-9 d-flex flex-row"> <span class="ml-3 mt-1"> من</span>
                            <input autocomplete="off" name="start_date" type="text" id="startdate" class="datepicker form-control start-date col-sm-3">
                            <span class="ml-3 mr-3 mt-1"> الى</span>
                            <input autocomplete="off" name="end_date" type = "text" id = "end-date" class="datepicker form-control col-sm-3">
                            <span class="ml-3 h-100 mt-1 w-25"> حدد الفرع</span>
                            <select name="branch_id" class="js-example-basic-single select form-control col-sm-6">
                                <option value=""></option>
                                @foreach($branches as $row)
                                    <option class="text-right" value="{{$row->id}}">{{$row->branchName}}</option>
                                @endforeach
                            </select>
                            <buttton class="btn btn-sm btn-success btn-submit mr-3">بحث</buttton>
                        </p>
                    </form>
                </div>
            </div>
            <div class="container text-right btn-outer" style="display:none;" >
                <button class="btn btn-danger selected_row">حذف المحدد</button>
            </div>
            <hr class="row">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex text-right"><h4>سجل حضور الموظفين</h4></div>
                <div class="col-sm-12 row justify-content-around">
                    <div class="col-sm-12 mr-3 border table-box">
                        <table class="table table-striped" id="emp_table">
                            <thead>
                            <tr>
                                <th class="text-right" scope="col">#</th>
                                <th class="text-right" scope="col">الرقم الوظيفي</th>
                                <th class="text-right" scope="col">وقت التسجيل</th>
                                <th class="text-right" scope="col">تاريخ التسجيل</th>
                                <th class="text-right" scope="col">الحالة</th>
                                <th class="text-right" scope="col">الفرع</th>
                                <th class="text-right" scope="col">الصورة</th>
                                <th class="text-center" scope="col" width="5%">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($precenses as $row)

                                <tr>
                                    <th class="text-right" scope="row">{{$loop->iteration}}</th>
                                    <th class="text-right" scope="row">{{$row->EMP_NAME}}</th>

                                    <td class="text-right">{{ date("h:i",strtotime($row->created_at))}}</td>


                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <div class="col-sm-12  d-flex justify-content-center">


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-box conatiner-fluid" style="display: none">
            <div class="row justify-content-center" style="margin-top: 20%">

                <div class="lds-dual-ring"></div>
            </div>
        </div>

    </main>
    <script src="{{asset('assets/js/webcam.min.js')}}"></script>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#startdate").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: 0,
                onSelect: function (date) {
                    var dt2 = $('#end-date');
                    var startDate = $(this).datepicker('getDate');
                    var minDate = $(this).datepicker('getDate');
                    if (dt2.datepicker('getDate') == null){
                        dt2.datepicker('setDate', minDate);
                    }
                    //dt2.datepicker('option', 'maxDate', '0');
                    dt2.datepicker('option', 'minDate', minDate);
                }
            });
            $('#end-date').datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: 0
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name=csrf-token]').attr('content')
            }
        })
    </script>
    <script>
        $(document).ready(function (){
            $('.js-example-basic-single').select2();
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN':$('meta[name=csrf-token]').attr('content')
                }
            })
            function presence (){
                let emp_id = $("[name=employee_id]").val();
                let branch_id = $("[name=branch_id]").val();
                let start_data= $("#startdate").val();
                let end_date = $("#end-date").val();
                $.ajax({
                    type:'get',
                    url:"/dashboard",
                    data: {'employee_id':emp_id
                        ,'start_date':start_data,
                        'end_date':end_date,
                        'branch_id':branch_id,
                    },
                    contentType: false,
                    dataType:'html',
                    success:function (response){
                        $('.table-box').html="";
                        $('.table-box').html(response)
                    },
                })
            }
            $(document).on('click','.btn-submit',function (){
              presence()
            })

            $(document).on('click','.selected_row',function (){
                Swal.fire({
                    title: 'هل انت متأكد؟',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'تم!',
                            'تم حذف المحدد بنجاح.',
                            'success'
                        )
                        let items = $('input:checked').map(function(i, e) {return e.value}).toArray();
                        let form_data = new FormData();
                        form_data.append('items',items);
                        $.ajax({
                            url:"/dashboard/presence/delete",
                            method:'post',
                            data: form_data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function (res){
                                if (res.status ==200) {
                                    $('.btn-outer').fadeOut()
                                    presence()
                                }

                            },
                            error:function (reject){
                                var response = $.parseJSON(reject.responseText);
                                swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text:response.errors.ids,
                                })
                            }
                        })

                    }
                })

            })

     });

    </script>
   <script>
        $(document).ajaxSend(function(event, request, settings) {
            $('.container-box').show();
        });

        $(document).ajaxComplete(function(event, request, settings) {
            $('.container-box').hide();
        });
    </script>
    <script>
        $(".delete-presenece")
    </script>
    <script>
        $(document).on("click","input[type=\"checkbox\"]",function (){
            if($(this).prop("checked") == true){
                $('.btn-outer').fadeIn()
            }
        })


    </script>
</body>

</html>
