<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taakmelding</title>
</head>
<body style="margin:0; padding:0; background-color:#f0f2f5; font-family: Arial, sans-serif; color:#37474F;">

  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" style="padding:40px 20px;">

    

        <!-- Card -->
        <table cellpadding="20" cellspacing="0" border="0" style="width:100%; max-width:600px; background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
          <tr>
            <td>

                <!-- Logo -->



              <!-- Header -->
                       <h2 style="color:#4a57a3; margin-bottom:15px; text-align:center;">
               {{ $data->type->getLabel() ?? $data->type->value }} 
              </h2>
 
 
                
              Wij hebben de ticket voor u geregistreerd. Hieronder vindt u de details van de ticket:
              <br><br>
                @if($data->description)
    <p style="margin-bottom:20px;">
        <strong>Omschrijving:</strong><br><br>
        {!! nl2br(e($data->description)) !!}
    </p>
 


</p>
              @endif

              <!-- Details Table -->
              <table cellpadding="10" cellspacing="0" border="0" 
                     style="width:100%; border-collapse:collapse; font-size:14px; 
                            background:#ffffff; border-radius:6px; border:1px solid #ffffff;">

            
                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Relatie</td>
                      <td style="border:1px solid #ffffff;"><b>{{ $data?->related_to?->name ?? "Geen" }}</b></td>
                  </tr>
         

                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Type</td>
                      <td style="border:1px solid #ffffff;">{{ $data->type->getLabel() ?? $data->type->value }}</td>
                  </tr>

                <tr>
                <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Prioriteit</td>
                 <td style="border:1px solid #ffffff;">
        @php
            $colors = [
                'low' => '#4caf50',      // groen
                'medium' => '#ff9800',   // oranje
                'high' => '#f44336',     // rood
            ];
            $priority = $data->priority->label ?? 'medium';
            $color = $colors[$priority] ?? '#999999';
        @endphp

        <span style="
            background: {{ $color }};
            letter-spacing: 1px;
            color: #ffffff;
            padding: 4px 8px;
            border-radius: 2px;
            font-size: 12px;
        ">
            {{ ucfirst($priority) }}
        </span>
    </td>
            </tr>

                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Aangemaakt op</td>
                      <td style="border:1px solid #ffffff;">{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</td>
                  </tr>

                  @if($data->begin_date)
                  <tr>
                      <td style=" background:#f5f5f5;  font-weight:bold; border:1px solid #ffffff;">Plan datum & tijd</td>
                      <td style="border:1px solid #ffffff;">
                          @php
                              $date = $data->begin_date ? \Carbon\Carbon::parse($data->begin_date)->format('d-m-Y') : null;
                              $time = $data->begin_time ? \Carbon\Carbon::parse($data->begin_time)->format('H:i') : null;
                              $isPast = $date && \Carbon\Carbon::parse($data->begin_date)->isPast();
                          @endphp
                          @if($date || $time)
                              <span >
                                  {{ $date ?? '' }} {{ $time ?? '' }}
                                  @if($isPast)
                                      <small style="color:#ffffff; background:#827fb0; padding:2px 6px; border-radius:3px; font-weight:normal; margin-left:5px;">Gestart</small>
                                  @endif
                              </span>
                          @else
                              -
                          @endif
                      </td>
                  </tr>
                  @endif

                  @if($data->deadline)
                  <tr>
                      <td style=" background:#f5f5f5 ; font-weight:bold; border:1px solid #ffffff;">Deadline</td>
                      <td style="border:1px solid #ffffff;">
                          @php
                              $deadline = \Carbon\Carbon::parse($data->deadline)->format('d-m-Y');
                              $isPast = \Carbon\Carbon::parse($data->deadline)->isPast();
                          @endphp
                          <span style="color: {{ $isPast ? 'red' : 'inherit' }};">
                              {{ $deadline }}
                              @if($isPast)
                                  <small style="color:#ffffff; background:red; padding:2px 6px; border-radius:3px; font-weight:normal; margin-left:5px;">Te laat</small>
                              @endif
                          </span>
                      </td>
                  </tr>
                  @endif

                  @if($data->employee_id)
                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Toegewezen aan</td>
                      <td style="border:1px solid #ffffff;">{{ $data?->employee?->name }}</td>
                  </tr>
                  @endif

                  @if($data->created_by)
                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Aangemaakt door</td>
                      <td style="border:1px solid #ffffff;">{{ $data?->creator?->name }}</td>
                  </tr>
                  @endif

                  @if($data->status)
                  <tr>
                      <td style="background:#f5f5f5; font-weight:bold; border:1px solid #ffffff;">Status</td>
                      <td style="border:1px solid #ffffff;">{{ $data->status }}</td>
                  </tr>
                  @endif

              </table>

              <!-- Footer -->
           

            </td>
          </tr>
        </table>
   <p style="font-size:12px; color:#999999; margin-top:30px; text-align:center;">
                © 2025 <a href="https://www.kwimbi.nl" target="_blank" style="color:#4a57a3; text-decoration:none;">www.kwimbi.nl</a>
              </p>
      </td>
    </tr>
  </table>

</body>
</html>
