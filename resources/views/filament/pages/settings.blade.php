<x-filament-panels::page>
   <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
   <div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
         @can('view_any_user')
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400  0" href="users">
            <img  src = "/images/icons/pack/conference_call.svg"   class = "max-h-12">
            <div>
               <h2>Medewerkers</h2>
               <p class="text-sm text-gray-600">Beheer de medewerkers</p>
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
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="tenant-settings">
            <img  src = "/images/icons/pack/candle_sticks.svg"   class = "max-h-12">
            <div>
               <h2>Omgeving instellingen</h2>
               <p class="text-sm text-gray-600">Bedrijfsinformatie, Vormgeving, Opties   </p>
            </div>
         </a>
         @can('view_any_relation::type')
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400  0" href="custom-fields">
            <img  src = "/images/icons/hand.svg"   class = "max-h-12">
            <div>
               <h2>Vrijvelden</h2>
               <p class="text-sm text-gray-600">Wijzig en voeg vrij velden toe </p>
            </div>
         </a>
         @endcan
      </div>
      <br>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
         @if(setting('use_vehiclemanagement'))
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/automotive.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Autobeheer</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/vehicles" class="text-black hover:underline">Voortuigen</a></li>
                  @can('view_any_vehicle::g::p::s')
                  <li><a href="/vehicle-g-ps" class="text-black hover:underline">GPS Trackers</a></li>
                  @endcan
               </ul>
            </div>
         </div>
         @endif
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/in_transit.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Categorieen</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/ticket-types" class="text-black hover:underline">Tickets</a></li>
                  <li><a href="/relation-types" class="text-black hover:underline">Relaties</a></li>
                  <li><a href="/contact-types" class="text-black hover:underline">Contactpersonen</a></li>
                  <li><a href="/location-types" class="text-black hover:underline">Locaties</a></li>
               </ul>
            </div>
         </div>
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/accept_database.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Statussen</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/project-statuses" class="text-black hover:underline">Projecten</a></li>
               </ul>
            </div>
         </div>
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/portrait_mode.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Werkbonnen & Tickets</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/errors" class="text-black hover:underline">Werkomschrijvingen</a></li>
                  <li><a href="/solutions" class="text-black hover:underline">Oplossing</a></li>
                  <li><a href="/workorder-activities" class="text-black hover:underline">Uursoorten</a></li>
               </ul>
            </div>
         </div>
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/edit_image.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Objecten</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/object-types" class="text-black hover:underline">Categorieen</a></li>
                  <li><a href="/brands" class="text-black hover:underline"></a>Merken en modellen</li>
               </ul>
            </div>
         </div>
         <div class="content flex py-5 gap-4 p-3 bg-white rounded-lg border border-gray-400">
            <img src="/images/icons/pack/cable_release.svg" class="max-h-12">
            <div>
               <h2 class="text-lg font-semibold mb-2">Artikelen</h2>
               <ul class="list-disc list-inside space-y-1">
                  <li><a href="/object-type" class="text-black hover:underline">Categorieen</a></li>
                  <li><a href="/brands" class="text-black hover:underline"></a>Artikelen bbeheer</li>
               </ul>
            </div>
         </div>
      </div>
      <br>
      @if(setting('module_elevators'))
      <h1 class="pb-2 text-lg font-medium text-gray-700 pt-5">Liften & Roltrappen Module</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="object-monitoring-codes">
            <img  src = "/images/icons/pack/bar_chart.svg"   class = "max-h-12">
            <div>
               <h2>Monitoringscodes</h2>
               <p class="text-sm text-gray-600">Fout codes voor object monitoring</p>
            </div>
         </a>
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="/connection/elevators/modusystem">
            <img  src = "/images/connections/elevators/modusystem.png"   class = "max-h-12">
            <div>
               <h2>Modusystem </h2>
               <p class="text-sm text-gray-600">Koppelings instellingen</p>
            </div>
         </a>
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="/elevator-inspection-zins">
            <img  src = "/images/connections/elevators/modusystem.png"   class = "max-h-12">
            <div>
               <h2>ZIN CODES </h2>
               <p class="text-sm text-gray-600">Koppelings instellingen</p>
            </div>
         </a>
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="/connection/elevators/liftinstituut">
            <img  src = "/images/connections/elevators/liftinstituut-logo-41197.webp"   class = "max-h-12">
            <div>
               <h2>Liftinstituut </h2>
               <p class="text-sm text-gray-600">Koppelings instellingen</p>
            </div>
         </a>
         <a class="content flex  py-5  gap-4 p-3 bg-white rounded-lg border border-gray-400" href="/connection/elevators/chex">
            <img  src = "/images/connections/elevators/chex.png"   class = "max-h-12">
            <div>
               <h2>Chex </h2>
               <p class="text-sm text-gray-600">Koppelings instellingen</p>
            </div>
         </a>
      </div>
      @endif
   </div>
</x-filament-panels::page>
