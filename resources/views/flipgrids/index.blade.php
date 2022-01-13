<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
    <div class="container">
        <h1>SNS Broadcasts</h1>
        <table class="table">
            <tr>
                <th scope="col">Record Date/Time</th>
                <th scope="col">Grid ID</th>
                <th scope="col">Question ID</th>
                <th scope="col">Response ID</th>
                <th scope="col">Payload</th>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>

</body>
</html>

