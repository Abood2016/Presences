<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" >

    <title>Presences System</title>

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
<div class="container mt-5">
    <div class="row justify-content-around">
        <div class="col-sm-5 row mr-3 ml-1 border" style="">
            <form action="" class="col-sm-12 row mt-3" id="form_submit" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}" >
                <div class="form-group col-sm-12 row">
                    <label for="" class="col-sm-12 row" style="margin-right: 0.01em">
                       <span class="mr-1">
                           الرقم الوظيفي
                       </span>
                        <input name="employee_num"  class="form-control col-sm-12 mt-2" type="text" placeholder="ادخل الرقم الوظيفي">
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
        <div class="col-sm-6 mr-3 border" style="overflow-y:scroll ;height:50vh!important;">
            <table class="table " >
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>

                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
<script src="{{asset('assets/js/webcam.min.js')}}"></script>



<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/js/jquery.min.js')}}" ></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}" ></script>
<script>
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
        Webcam.snap(function (data_uri){
        form_data.append("image",data_uri)
        })


        $.ajax({
            url:"/add-presences",
            method:"post",
            data:form_data,
            contentType: false,
            cache: false,
            processData: false,
            success:function (){
                $('#permission').modal('hide')
            }
        })
    })

</script>
</body>
</html>
