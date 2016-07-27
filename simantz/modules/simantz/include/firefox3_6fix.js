if (!document.getBoxObjectFor) {
  document.getBoxObjectFor = function(el) {
    if (!(el instanceof HTMLElement)) {
      return;
    } //else:
    var b = el.getBoundingClientRect(), c = el.offsetParent instanceof
HTMLTableElement, p = el,
      x = sx = b.left - (c ? 0 : el.offsetLeft), y = sy = b.top - (c ?
0 : el.offsetTop), w = window;
    while (!(p instanceof HTMLHtmlElement)) {
      sx += p.scrollLeft;
      sy += p.scrollTop;
      p = p.parentNode;
    }
    return { x: sx, y: sy, width: Math.round(b.width), height:
Math.round(b.height),
      element: el, firstChild: el, lastChild: el, previousSibling:
null, nextSibling: null, parentBox: el.parentNode,
      screenX: x + w.screenX + (w.outerWidth - w.innerWidth) / 2,
screenY: y + w.screenY + (w.outerHeight - w.innerHeight) / 2
    };
  };
}

