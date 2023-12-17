<div>
    <table>
        <thead>
            <tr class="thead">
                <th>Vehicle vector</th>
                <th>Time spent on the road</th>
            </tr>
        </thead>
        <tbody>
            @foreach($times as $time)
                <tr class="tbody">
                    <th class="">
                        <p>{{ $time['vector'] }}</p>
                    </th>
                    <th class="">
                        <p>{{ $time['time'] }} seconds</p>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
table {
  border-collapse: collapse;
  width: 100%;
}

.thead {
    background-color: #ececec;
}

.tbody {
    background-color: #dedede;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #909090;
}
</style>