<table class="table table-striped" id="emp_table">
    <thead>
    <tr>
        <th class="text-right" scope="col">#</th>
        <th class="text-right" scope="col">الرقم الوظيفي</th>
        <th class="text-right" scope="col">تاريخ التسجيل</th>
        <th class="text-right" scope="col">اليوم</th>
        <th class="text-right" scope="col">وقت التسجيل</th>
        <th class="text-right" scope="col">الحالة</th>
        <th class="text-right" scope="col">الفرع</th>
        <th class="text-right" scope="col">الصورة</th>

    </tr>
    </thead>
    <tbody>
<?php

?>
    @foreach($precenses as $row)

        <tr>
            <th class="text-right" scope="row">{{$loop->iteration}}</th>
            <th class="text-right" scope="row">{{$row->employdd_id}}</th>
            <td class="text-right">
                {{ date("h:i",strtotime($row->att_date))}}
            </td>
            <td class="text-right">
                <?php
                $day =
                ["Sunday"=>'الأحد','Monday'=>'الاثنين','Wednesday'=>"الأربعاء",
                    'Thursday'=>'الخميس','Saturday'=>'السبت','Tuesday'=>'الثلاثاء'];

                ?>

                {{ $day[date("l",strtotime($row->att_date))]}}
            </td>
            <td class="text-right">
                {{ date("Y-m-d",strtotime($row->att_date))}}
            </td>
            <td class="text-right" scope="row">
                @if ($row->status == 'C/In')
                    <span class="badge badge-success">تسجيل دخول</span>
                @else
                    <span class="badge badge-primary">تسجيل خروج</span>
                @endif
            </td>
            <td class="text-right">
                {{$row->branchName}}
            </td>
            <td>
            <td class="text-right">
                <a href="{{asset('storage/').'/'.$row->image }}" target="_blank"><img width="130px"
                                                                                      style="border-radius: 30px" src="{{ asset('storage/'.$row->image  ) }}">
                </a>
            </td>

        </tr>
    @endforeach
    </tbody>

</table>
