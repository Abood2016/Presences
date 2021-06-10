<table class="table table-striped" id="emp_table">
    <thead>
    <tr>
        <th class="text-right" scope="col">#</th>
        <th class="text-right" scope="col">الرقم الوظيفي</th>
        <th class="text-right" scope="col">الحالة</th>
        <th class="text-right" scope="col">تاريخ التسجيل</th>
        <th class="text-right" scope="col">الصورة</th>

    </tr>
    </thead>
    <tbody>
    @foreach($presences as $row)

        <tr>
            <th class="text-right" scope="row">{{$loop->iteration}}</th>
            <th class="text-right" scope="row">{{$row->employee_id}}</th>
            <th class="text-right" scope="row">{{$row->status}}</th>
            <td class="text-right">{{ $row->created_at->format('y-m-d') }}</td>

            <th class="text-right" scope="row">
                @if ($row->status == 'C/In')
                    <span class="badge badge-success">تسجيل دخول</span>
                @else
                    <span class="badge badge-primary">تسجيل خروج</span>
                @endif
            </th>
            <td class="text-right">{{ $row->created_at->format('y-m-d') }}
            <td>

            <td class="text-right">
                <a href="{{asset('storage/').'/' .$row->image}}" target="_blank"><img width="130px"
                                                                                      style="border-radius: 30px" src="{{ asset('storage/' . $row->image) }}">
            </td>

        </tr>
    @endforeach
    </tbody>

</table>
