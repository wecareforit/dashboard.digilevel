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
        <table cellpadding="20" cellspacing="0" border="0" style="width:100%; max-width:600px; background:#ffffff; border-radius:10px; box-shadow:0 3px 12px rgba(0,0,0,0.08);">
          <tr>
            <td>

              <!-- Header -->
              <h2 style="color:#4a57a3; margin:0 0 20px; text-align:center; font-size:22px;">
                {{ $data->type->getLabel() ?? $data->type->value }} 
              </h2>

              <!-- Description -->
              @if($data->description)
              <p style="margin-bottom:20px; line-height:1.5; font-size:14px;">
                <strong>Omschrijving:</strong><br>
                {!! nl2br(e($data->description)) !!}
              </p>
              @endif

              <!-- Details Table -->
              <table cellpadding="10" cellspacing="0" border="0" 
                     style="width:100%; border-collapse:collapse; font-size:14px; border:1px solid #e0e0e0; border-radius:6px; overflow:hidden;">
            
                <tr>
                  <td style="background:#f9f9f9; font-weight:bold; width:35%;">Relatie</td>
                  <td>{{ $data?->related_to?->name ?? "Geen" }}</td>
                </tr>

                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Type</td>
                  <td>{{ $data->type->getLabel() ?? $data->type->value }}</td>
                </tr>

                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Prioriteit</td>
                  <td>
                    @php
                      $colors = [
                        'low' => '#4caf50',
                        'medium' => '#ff9800',
                        'high' => '#f44336',
                      ];
                      $priority = $data->priority->label ?? 'medium';
                      $color = $colors[$priority] ?? '#999999';
                    @endphp
                    <span style="
                      background: {{ $color }};
                      color:#fff;
                      padding:4px 10px;
                      border-radius:4px;
                      font-size:12px;
                      text-transform:capitalize;
                    ">
                      {{ $priority }}
                    </span>
                  </td>
                </tr>

                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Aangemaakt op</td>
                  <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i') }}</td>
                </tr>

                @if($data->begin_date)
                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Plan datum & tijd</td>
                  <td>
                    @php
                      $date = $data->begin_date ? \Carbon\Carbon::parse($data->begin_date)->format('d-m-Y') : null;
                      $time = $data->begin_time ? \Carbon\Carbon::parse($data->begin_time)->format('H:i') : null;
                      $isPast = $date && \Carbon\Carbon::parse($data->begin_date)->isPast();
                    @endphp
                    @if($date || $time)
                      {{ $date ?? '' }} {{ $time ?? '' }}
                      @if($isPast)
                        <small style="color:#fff; background:#827fb0; padding:2px 6px; border-radius:3px; margin-left:6px;">Gestart</small>
                      @endif
                    @else
                      -
                    @endif
                  </td>
                </tr>
                @endif

                @if($data->deadline)
                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Deadline</td>
                  <td>
                    @php
                      $deadline = \Carbon\Carbon::parse($data->deadline)->format('d-m-Y');
                      $isPast = \Carbon\Carbon::parse($data->deadline)->isPast();
                    @endphp
                    <span style="color: {{ $isPast ? 'red' : 'inherit' }};">
                      {{ $deadline }}
                      @if($isPast)
                        <small style="color:#fff; background:red; padding:2px 6px; border-radius:3px; margin-left:6px;">Te laat</small>
                      @endif
                    </span>
                  </td>
                </tr>
                @endif

               @if($data->make_by_employee_id)
                <tr>
                    <td style="background:#f9f9f9; font-weight:bold;">Aangemaakt door</td>
                    <td>{{ $data?->make_by_employee?->name }}</td>
                </tr>
                @endif

                @if($data->employee_id && $data->employee_id !== $data->make_by_employee_id)
                  <tr>
                    <td style="background:#f9f9f9; font-weight:bold;">Toegewezen aan</td>
                    <td>{{ $data?->employee?->name }}</td>
                  </tr>
                @endif
                
                @if($data->created_by)
                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Aangemaakt door</td>
                  <td>{{ $data?->creator?->name }}</td>
                </tr>
                @endif

                @if($data->status)
                <tr>
                  <td style="background:#f9f9f9; font-weight:bold;">Status</td>
                  <td>{{ $data->status }}</td>
                </tr>
                @endif

              </table>

            </td>
          </tr>
        </table>

        <!-- Footer -->
        <p style="font-size:12px; color:#999999; margin-top:25px; text-align:center;">
          © 2025 <a href="https://www.kwimbi.nl" target="_blank" style="color:#4a57a3; text-decoration:none;">www.kwimbi.nl</a>
        </p>

      </td>
    </tr>
  </table>

</body>
</html>
