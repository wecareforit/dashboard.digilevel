<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
<div>
    <div class="energy-class">
        @if($getState()=='A')
            <div class="a"></div>
        @elseif($getState()=='B')
            <div class="b"></div>
        @elseif($getState()=='C')
            <div class="c"></div>
        @elseif($getState()=='D')
            <div class="d"></div>
        @elseif($getState()=='E')
            <div class="e"></div>
        @elseif($getState()=='F')
            <div class="f"></div>
        @elseif($getState()=='G')
            <div class="g"></div>
        @else
        <div class="fi-in-placeholder text-sm leading-6 text-gray-400 dark:text-gray-500">
            Niet opgegeven
        </div>
        @endif
    </div>
</div> 
</x-dynamic-component>

<style>
 .energy-class {
	position: relative;
	width: 155px;
	font-family : sans-serif;
  }
  .energy-class span {
	display: block;
	position: absolute;
	left: 110%;
	background: #000;
	width: 30px;
	height: 30px;
  }
  .energy-class span.a {
	top: 0px;
  }
  .energy-class span.b {
	top: 20px;
  }
  .energy-class span.c {
	top: 40px;
  }
  .energy-class span.d {
	top: 60px;
  }
  .energy-class span.e {
	top: 80px;
  }
  .energy-class span.f {
	top: 100px;
  }
  .energy-class span.g {
	top: 120px;
  }
  .energy-class span:before {
	content: '';
	position: absolute;
	top: 0;
	right: 100%;
	width: 0;
	height: 0;
	border-top: 15px solid transparent;
	border-right: 15px solid #000;
	border-bottom: 15px solid transparent;
  }
  .energy-class span:after {
	position: absolute;
	top: 0;
	left: 0;
	width: 30px;
	line-height: 30px;
	text-align: center;
	color: #fff;
	font-size: 30px;
	text-transform: uppercase;
  }
  .energy-class span.a:after {
	content: ' a ';
  }
  .energy-class span.b:after {
	content: ' b ';
  }
  .energy-class span.c:after {
	content: ' c ';
  }
  .energy-class span.d:after {
	content: ' d ';
  }
  .energy-class span.e:after {
	content: ' e ';
  }
  .energy-class span.f:after {
	content: ' f ';
  }
  .energy-class span.g:after {
	content: ' g ';
  }
  .energy-class div {
	position: relative;
	height: 20px;
	margin: 2px 0;
  }
  .energy-class div:before {
	content: '';
	position: absolute;
	top: 0;
	left: 100%;
	background: transparent;
	width: 0;
	height: 0;
	border-top: 10px solid transparent;
	border-bottom: 10px solid transparent;
  }
  .energy-class div:after {
	position: absolute;
	top: 0;
	right: 0.25em;
	height: 20px;
	line-height: 20px;
	color: #fff;
	text-shadow: 0 0 2px #000;
	text-transform: uppercase;
  }
  .energy-class div.a {
	background: #3b7634;
	width: 50px;
  }
  .energy-class div.a:before {
	border-left: 8px solid #3b7634;
  }
  .energy-class div.a:after {
	content: ' a ';
  }
  .energy-class div.b {
	background: #5da436;
	width: 65px;
  }
  .energy-class div.b:before {
	border-left: 8px solid #5da436;
  }
  .energy-class div.b:after {
	content: ' b ';
  }
  .energy-class div.c {
	background: #a3cf2a;
	width: 80px;
  }
  .energy-class div.c:before {
	border-left: 8px solid #a3cf2a;
  }
  .energy-class div.c:after {
	content: ' c ';
  }
  .energy-class div.d {
	background: #f6df1b;
	width: 95px;
  }
  .energy-class div.d:before {
	border-left: 8px solid #f6df1b;
  }
  .energy-class div.d:after {
	content: ' d ';
  }
  .energy-class div.e {
	background: #f29020;
	width: 110px;
  }
  .energy-class div.e:before {
	border-left: 8px solid #f29020;
  }
  .energy-class div.e:after {
	content: ' e ';
  }
  .energy-class div.f {
	background: #eb422c;
	width: 125px;
  }
  .energy-class div.f:before {
	border-left: 8px solid #eb422c;
  }
  .energy-class div.f:after {
	content: ' f ';
  }
  .energy-class div.g {
	background: #ea2039;
	width: 140px;
  }
  .energy-class div.g:before {
	border-left: 8px solid #ea2039;
  }
  .energy-class div.g:after {
	content: ' g ';
  }
   
 </style> 
