 
<div>
    <div class="energy-class">

    <div class="icon-row">
 

        @if($getRecord()->fire_elevator==1)
        <img class="icon" style = "height: 20px; " src = "/images/icons/fire.png">
       @endif

               @if($getRecord()->stretcher_elevator==1)
        <img class="icon" style = "height: 20px; float: right " src = "/images/icons/brancard.jpg">
       @endif
</div>
    </div>









</div> 
  

<style>

.icon-row {
  display: flex;
  align-items: center; /* verticale uitlijning */
  gap: 8px; /* ruimte tussen iconen */
}
.icon {
 
  height: 32px;
}
  </style>