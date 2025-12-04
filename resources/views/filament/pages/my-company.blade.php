<x-filament-panels::page>
   <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
   <div>

      <div class="grid grid-cols-4 gap-4 max-xl:grid-cols-3 max-md:grid-cols-2">

         @can('view_any_user')
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400  0" href="users">
            <img  src = "/images/icons/pack/conference_call.svg"   class = "max-h-12">
            <div>
               <h2>Medewerkers</h2>
               <p class="text-sm text-gray-600">Beheer de medewerkersn</p>
            </div>
         </a>
         @endcan

         @if(setting('use_company_locations'))
            @can('view_any_location')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400  0" href="locations">
               <img  src = "/images/icons/pack/department.svg"  class = "max-h-12">
               <div>
                  <h2>Locaties</h2>
                  <p class="text-sm text-gray-600">Beheer de locaties je bedrijf</p>
               </div>
            </a>
            @endcan
         @endif



         @if(setting('use_company_spaces'))
            @can('view_any_department')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="departments">
               <img  src = "/images/icons/pack/collaboration.svg"   class = "max-h-12">
               <div>
                  <h2>Afdelingen</h2>
                  <p class="text-sm text-gray-600">Beheer de afdelingen in je bedrijf</p>
               </div>
            </a>
            @endcan
         @endif


         @if(setting('use_company_spaces'))
            @can('view_any_space')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="spaces">
               <img  src = "/images/icons/pack/org_unit.svg"   class = "max-h-12">
               <div>
                  <h2>Ruimtes</h2>
                  <p class="text-sm text-gray-600">Beheer de ruimtes in je bedrijf</p>
               </div>
            </a>
            @endcan
         @endif

         @can('view_any_role')
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="/shield/roles">
            <img  src = "/images/icons/pack/grid.svg"   class = "max-h-12">
            <div>
               <h2>Gebruikersrollen</h2>
               <p class="text-sm text-gray-600">Rechten groepen voor de gebruikers</p>
            </div>
         </a>
         @endcan

         @if(setting('use_vehiclemanagement'))
            @can('view_any_vehicle')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="vehicles">
               <img  src = "/images/icons/pack/candle_sticks.svg"   class = "max-h-12">
               <div>
                  <h2>Auto beheer</h2>
                  <p class="text-sm text-gray-600">Voertuigenbeheer</p>
               </div>
            </a>
            @endcan
         @endif

         @if(setting('use_gps_tracker'))
            @can('view_any_vehicle::g::p::s')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="vehicle-g-ps">
               <img  src = "/images/icons/pack/automotive.svg"   class = "max-h-12">
               <div>
                  <h2>GPS Modules</h2>
                  <p class="text-sm text-gray-600">GPS modules voor voortuigen</p>
               </div>
            </a>
            @endcan
         @endif

         @if(setting('use_company_warehouses'))
            @can('view_any_warehouse')
            <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="warehouses">
               <img  src = "/images/icons/pack/businessman.svg"   class = "max-h-12">
               <div>
                  <h2>Magazijnen</h2>
                  <p class="text-sm text-gray-600">Beheer de magazijnen in je bedrijf</p>
               </div>
            </a>
            @endcan
         @endif


         @can('view_any_warehouse')
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="warehouses">
            <img  src = "/images/icons/pack/businessman.svg"   class = "max-h-12">
            <div>
               <h2>Voorraden</h2>
               <p class="text-sm text-gray-600">Beheer de magazijnen in je bedrijf</p>
            </div>
         </a>
         @endcan






      </div>
      </div>


</x-filament-panels::page>
