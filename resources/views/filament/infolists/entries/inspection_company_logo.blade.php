<!-- Column 1: Logo overlay -->
@if($getRecord()->elevator?->inspection_company_id == env('CHEX_COMPANY_ID'))
    <img src="/images/connections/elevators/chex.png" 
         alt="CHEX Logo" 
         style="  height: 100px; z-index: 10;">

@elseif($getRecord()->elevator?->inspection_company_id == env('LIFTINSTITUUT_COMPANY_ID'))
    <img src="/images/connections/elevators/liftinstituut-logo-41197.webp" 
         alt="Liftinstituut Logo" 
         style=" ; height: 100px; z-index: 10;">

@else

@endif