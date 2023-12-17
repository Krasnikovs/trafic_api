<?php

?>
<div>
    <table>
        <thead>
            <tr class="thead">
                <th>Vehicle vector</th>
                <th>Position</th>
                <th>Time slot</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr class="tbody">
                    <th class="">
                        <p>{{ $vehicle->vector }}</p>
                    </th>
                    <th class="">
                        <p>{{ $vehicle->position }}</p>
                    </th>
                    <th class="">
                        <p>{{ $vehicle->timestamp }}</p>
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