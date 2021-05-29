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
