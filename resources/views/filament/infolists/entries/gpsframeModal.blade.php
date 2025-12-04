@if($record->lat)
    <iframe width="100%" height="600" src="https://maps.google.com/maps?q={{$record->lat}}, {{$record->lng}}&output=embed"></iframe>
    @else
        <center>Geen gegegevens gevonden</center>
    @endif
