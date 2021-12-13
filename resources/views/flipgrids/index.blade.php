<table border="1">
    <tr>
        <td>Grid ID</td>
        <td>Topic ID</td>
    </tr>
    @foreach($flipgrids as $flipgrid)
        <tr>
            <td>{{ $flipgrid->grid_id }}</td>
            <td>{{ $flipgrid->topic_id }}</td>
        </tr>
    @endforeach
</table>
