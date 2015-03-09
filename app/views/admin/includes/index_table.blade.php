<table class = "table">
    <thead>
        <tr>
            @foreach($header as $th)
            <th class="col-md-2">{{ $th }}</th>
            @endforeach
            <th></th>
            <th class="col-md-2">
                {{ Form::checkbox('erase', true, false, ['id' => 'check-all']) }}

                <button type = 'button' class="btn-link" data-toggle="modal" data-target="#modal-erase">
                    <span  class="glyphicon glyphicon-trash"></span> Borrar selección
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($data->getCollection()->toArray() as $tr)
        <tr data-row-id="{{ $tr['id'] }}">
            @foreach($tr as $td)
            <td class='col-md-2'>{{ $td }}</td>
            @endforeach
            <td class="text-right">
                <a href = "{{ URL::route("admin.$restful.edit", ['id' => $tr['id']]) }}">
                    <span class = "glyphicon glyphicon-pencil"></span>
                </a>
            </td>
            <td class="col-md-2">
                {{ Form::checkbox('erase', $tr['id'], false, ['class' => 'delete-check']) }}
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
<div class="col-md-12 text-center">
    {{ $data->links() }}
</div>