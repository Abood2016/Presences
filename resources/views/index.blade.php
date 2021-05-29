<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" >
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}" >

    <title>Presences System</title>
    <style>

        .clock {
            color: #000000;
            font-size: 60px;
            font-family: Arial;
            letter-spacing: 7px;
            font-weight: 300;

        }
        .image{
            height: 250px;
            width: 250px;
            border-radius: 30px;
            margin-top: 2em;
        }

    </style>
</head>
<body>
<!-- Image and text -->
<header>
<nav class="navbar navbar-light" style="background-color: black;">
    <a class="navbar-brand" href="{{url('/')}}">
        <img src="{{asset('assets/images/logo.jpeg')}}" width="150" height="50" class="d-inline-block align-top" alt="">
    </a>
</nav>
</header>
<main>
    <div class="container" style="margin-top: 1em">
        <div class="row justify-content-center">
            <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

        </div>
    </div>
<div class="container mt-2">
    <div class="row justify-content-around">
        <div class="col-sm-5 row mr-3 ml-1 border" style="">
            <form action="" class="col-sm-12 row mt-3" id="form_submit" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" >
                <div class="form-group col-sm-12 row">
                    <label for="" class="col-sm-12 row" style="margin-right: 0.01em">
                       <span class="mr-1">
                           الرقم الوظيفي
                       </span>
                        <input name="employee_id"  class="form-control col-sm-12 mt-2" type="text" placeholder="ادخل الرقم الوظيفي">
                    </label>
                </div>
                <div class="form-group row col-sm-12">
                    <div class=" col-sm-6 text-right">
                        <label class="form-check-label" for="flexRadioDefault1">
                          تسجيل دخول
                        </label>
                        <input class="form-check-input mr-1 mt-2" checked name="status" value="C/In" type="radio"
                               name="flexRadioDefault" id="flexRadioDefault1">
                    </div>
                    <div class="col-sm-6 text-right">
                        <label class="form-check-label" for="flexRadioDefault2">
                            تسجيل خروج
                        </label>
                        <input class="form-check-input mr-1 mt-2" name="status" value="C/Out" type="radio" name="flexRadioDefault"
                               id="flexRadioDefault2">
                    </div>
                    <div id="camera" style="display: none"></div>
                    <div id="result" style=""></div>
                    <div class="row w-100 justify-content-center">
                        <div>
                        <button type="button" class="btn btn-primary btn_submit">تسجيل</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="col-sm-6 mr-3 border table-box" style="overflow-y:scroll ;height:50vh!important;">
            <table class="table " >
                <thead>
                <tr>
                    <th class="text-right" scope="col">#الرقم الوظيفي</th>
                    <th class="text-right" scope="col">الحالة</th>
                    <th class="text-right" scope="col">الوقت</th>

                </tr>
                </thead>
                <tbody>
                @foreach($presence as $row)

                <tr>
                    <th class="text-right" scope="row">{{$row->employee_id}}</th>
                    <td class="text-right">{{$row->status}}</td>
                    <td class="text-right">{{ $row->created_at->format('H:s:i') }}
                    </td>

                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <div class=" row col-sm-12 justify-content-center">
        <div id="image" ></div>
    </div>
</div>
</main>
<script src="{{asset('assets/js/webcam.min.js')}}"></script>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/js/jquery.min.js')}}" ></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}" ></script>
<script src="{{asset('assets/js/sweetalert.js')}}" ></script>
<script>

    $(document).ready(function (){
        Webcam.set({
            width:350,
            height:350,
            image_format:'jpeg',
            jpeg_quality:90
        })
        Webcam.attach("#camera")

        /*   */
        $(document).on('click','.btn_submit',function (event){
            var form_id = document.getElementById('form_submit');
            var form_data = new FormData(form_id);
          var image ="";
            Webcam.snap(function (data_uri){

               image = data_uri
                form_data.append("image",data_uri)
            })


            $.ajax({
                url:"/add-presences",
                method:"post",
                data:form_data,
                contentType: false,
                cache: false,
                processData: false,
                success:function (response){
                    if (response.status == 504){
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: response.error,
                            confirmButtonText:"حسناً"
                        })
                    }
                    else {

                        Swal.fire({
                            icon: 'success',
                            title: 'تم',
                            text: response.success,
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })

                        document.getElementById('image').innerHTML =
                            '<img class="image" src="'+image+'"/>';

                        setTimeout(function (){
                            $("#form_submit").trigger('reset');
                        $("#image").html('')
                        },3000)
                        $.ajax({
                            url:"/presence",
                            method:'get',
                            data:{"_token":'{{csrf_token()}}'},
                            success:function (response){
                            $('.table-box').html="";
                            $('.table-box').html(response)
                            }
                        })
                    }
                }
            })
        })
        $('#form_submit').keypress(function (e) {
            if (e.which == 13) {
                $('.btn_submit').trigger('click');
                return false;    //<---- Add this line
            }
        });
    })


</script>
<script>
    function showTime(){
        var date = new Date();
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        var session = "ص";

        if(h == 0){
            h = 12;
        }

        if(h > 12){
            h = h - 12;
            session = "م";
        }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;

        setTimeout(showTime, 1000);

    }

    showTime();
</script>
</body>
</html>
