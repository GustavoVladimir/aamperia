function round(value, decimals) {
	return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

function dinero(n, signo, decimals) {
	var c = isNaN(decimals) ? 2 : Math.abs(decimals),
		d = '.',
		t = ',', 
		simbolo = (signo == false) ? "" : "$ ", 
		sign = (n < 0) ? '-' : '',
		i = parseInt(n = Math.abs(n).toFixed(c)) + '',
		j = ((j = i.length) > 3) ? j % 3 : 0;

	return simbolo + sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
}

function cambiar_fondo_canvas(canvas, color) {
  // Get the 2D drawing context from the provided canvas.
  const context = canvas.getContext('2d');

  // We're going to modify the context state, so it's
  // good practice to save the current state first.
  context.save();

  // Normally when you draw on a canvas, the new drawing
  // covers up any previous drawing it overlaps. This is
  // because the default `globalCompositeOperation` is
  // 'source-over'. By changing this to 'destination-over',
  // our new drawing goes behind the existing drawing. This
  // is desirable so we can fill the background, while leaving
  // the chart and any other existing drawing intact.
  // Learn more about `globalCompositeOperation` here:
  // https://developer.mozilla.org/en-US/docs/Web/API/CanvasRenderingContext2D/globalCompositeOperation
  context.globalCompositeOperation = 'destination-over';

  // Fill in the background. We do this by drawing a rectangle
  // filling the entire canvas, using the provided color.
  context.fillStyle = color;
  context.fillRect(0, 0, canvas.width, canvas.height);

  // Restore the original context state from `context.save()`
  context.restore();
}