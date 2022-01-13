<table border="1">
    <tr>
        <td>Record Date/Time</td>
        <td>Grid ID</td>
        <td>Question ID</td>
        <td>Response ID</td>
        <td>Payload</td>
    </tr>
    @foreach($flipgrids as $flipgrid)
        <tr>
            <td>{{ $flipgrid->created_at->format('Y-m-d h:m') }}</td>
            <td>{{ $flipgrid->fgGridID }}</td>
            <td>{{ $flipgrid->fgQuestionID }}</td>
            <td>{{ $flipgrid->fgResponseID }}</td>
            <td>{{ $flipgrid->payload }}</td>
        </tr>
    @endforeach
</table>
