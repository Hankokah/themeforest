<div id="container">
	<div id="svg-container">
		<svg width="200px" height="150px" viewBox="0 0 200 150">
			<path id="main" fill="none" stroke="<?php echo $page_loader_color;?>" stroke-width="31" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
M99.8,26.6c12.3,0,24.7,4.7,34.1,14.1c18.8,18.8,18.8,49.3,0,68.2s-49.3,18.8-68.2,0s-18.8-49.3,0-68.2
C75.2,31.3,87.5,26.6,99.8,26.6" />
			<path id="outer" fill="none" stroke="<?php echo $page_loader_color2;?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
M100.2,11.8c16.1,0,32.3,6.1,44.6,18.4c24.6,24.6,24.6,64.5,0,89.1c-24.6,24.6-64.5,24.6-89.1,0s-24.6-64.5,0-89.1
C67.9,18,84,11.8,100.2,11.8" />
			<path id="inner" fill="none" stroke="<?php echo $page_loader_color2;?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" d="
M100.2,42.5c-8.3,0-16.6,3.2-22.9,9.5c-12.6,12.6-12.6,33.2,0,45.8c12.6,12.6,33.2,12.6,45.8,0c12.6-12.6,12.6-33.2,0-45.8
C116.7,45.6,108.5,42.5,100.2,42.5" />
			<path id="end" fill="none" stroke="<?php echo $page_loader_color2;?>" stroke-width="2" stroke-miterlimit="10" d="M100.2,42.5c-9.1,0-16.5-6.9-16.5-15.4
s7.4-15.4,16.5-15.4" />
			<ellipse id="ring" fill="<?php echo $page_loader_color;?>" stroke="<?php echo $page_loader_color2;?>" stroke-width="2" stroke-miterlimit="10" cx="100.2" cy="27.1" rx="16.5" ry="15.3" />
			<g id="seeds" stroke="<?php echo $page_loader_color2;?>" fill="<?php echo $page_loader_color;?>">
				<path d="m103.854424,20.226112c1.12899,-1.454735 2.632462,-2.175968 3.359604,-1.611647c0.72715,0.564323 0.401665,2.19976 -0.727318,3.654495c-1.12899,1.454735 -2.632454,2.175968 -3.359604,1.611647c-0.72715,-0.564323 -0.401665,-2.19976 0.727318,-3.654495z"/>
				<path d="m93.685822,30.870628c1.243896,-1.357691 2.801476,-1.953495 3.480522,-1.331362c0.679054,0.622133 0.221527,2.225788 -1.022362,3.583471c-1.243889,1.357693 -2.801468,1.953499 -3.480522,1.331364c-0.679047,-0.622135 -0.221527,-2.22578 1.022362,-3.583473z"/>
				<path d="m104.679482,33.112373c-1.40815,-1.186613 -2.068024,-2.718245 -1.474533,-3.422531c0.593491,-0.704287 2.214813,-0.313591 3.622963,0.873032c1.408142,1.186619 2.068024,2.718246 1.474525,3.422531c-0.593491,0.704288 -2.214813,0.313591 -3.622955,-0.873032z"/>
				<path d="m93.85379,21.488874c-1.005424,-1.542755 -1.194817,-3.199705 -0.42321,-3.70257c0.771614,-0.502865 2.211006,0.339451 3.216431,1.882206c1.005424,1.542755 1.194817,3.199705 0.42321,3.70257c-0.771614,0.502865 -2.211006,-0.339451 -3.216431,-1.882206z"/>
			</g>
		</svg>
	</div>
</div>
<script>
	(function() {
		var container = document.getElementById('container');
		var svgContainer = document.getElementById('svg-container');
		var loader = document.getElementById('loader');
		var outer = document.getElementById('outer');
		var inner = document.getElementById('inner');
		var ring = document.getElementById('ring');
		var seeds = document.getElementById('seeds');
		var main = document.getElementById('main');
		var mainRing = document.getElementById('main-ring');

		TweenMax.set([svgContainer, 'svg'], {
			position: 'absolute',
			top: '50%',
			left: '50%',
			transformOrigin: '50% 50%',
			xPercent: -50,
			yPercent: -50
		})

		TweenMax.set(container, {
			position: 'absolute',
			top: '50%',
			left: '50%',
			transformOrigin: '50% 50%',
			xPercent: -50,
			yPercent: -50
		})

		var tl = new TimelineMax({
			repeatDelay: 0,
			repeat: -1,
			yoyo: true
		});

		tl.timeScale(3.4);

		tl.set([outer, main], {
			drawSVG: '0% 0%'
		})
		.set([inner], {
			drawSVG: '100% 100%'
		})
		.set(svgContainer, {
			transformOrigin: '50% 50%'
		})
		.set(ring, {
			transformOrigin: '50% 63px',
			rotation: -360
		})
		.set(seeds, {
			transformOrigin: '50% 54px',
			rotation: -360
		})
		.to([outer], 8, {
			drawSVG: '100% 0%',
			ease: Power4.easeInOut
		})
		.to([inner, main], 8, {
			drawSVG: '0% 100%',
			ease: Power4.easeInOut
		}, '-=8')
		.to([ring], 8, {
			rotation: 0,
			ease: Power4.easeInOut
		}, '-=8')
		.to([seeds], 8, {
			rotation: 0,
			ease: Power4.easeInOut
		}, '-=8')
		.to(svgContainer, 8, {
			rotation: 360,
			ease: Back.easeInOut.config(1.3)
		}, '-=8')
	})();
	</script>