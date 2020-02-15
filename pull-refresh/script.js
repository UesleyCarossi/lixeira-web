(() => {
if (!CSS.supports('overscroll-behavior-y', 'contain')) {
  alert("Your browser doesn't support overscroll-behavior :(");
}

async function simulateRefreshAction() {
  const sleep = (timeout) => new Promise(resolve => setTimeout(resolve, timeout));

  const transitionEnd = function(propertyName, node) {
    return new Promise(resolve => {
      function callback(e) {
        e.stopPropagation();
        if (e.propertyName === propertyName) {
          node.removeEventListener('transitionend', callback);
          resolve(e);
        }
      }
      node.addEventListener('transitionend', callback);
    });
  }

  const refresher = document.querySelector('.refresher');

  document.body.classList.add('refreshing');
  await sleep(2000);

  refresher.classList.add('shrink');
  await transitionEnd('transform', refresher);
  refresher.classList.add('done');

  refresher.classList.remove('shrink');
  document.body.classList.remove('refreshing');
  await sleep(0); // let new styles settle.
  refresher.classList.remove('done');
}

let _startY = 0;

const inbox = document.querySelector('#inbox');

inbox.addEventListener('touchstart', e => {
  _startY = e.touches[0].pageY;
}, {passive: true});

inbox.addEventListener('touchmove', e => {
  const y = e.touches[0].pageY;
  // Activate custom pull-to-refresh effects when at the top fo the container
  // and user is scrolling up.
  if (document.scrollingElement.scrollTop === 0 && y > _startY &&
      !document.body.classList.contains('refreshing')) {
    simulateRefreshAction();
  }
}, {passive: true});

})();