/* global window, document */
if (! window._babelPolyfill) {
  require('@babel/polyfill');
}

import React from 'react';
import ReactDOM from 'react-dom';
import Admin from './containers/Admin.jsx';

document.addEventListener('DOMContentLoaded', function() {
  console.log( window.uuc_object );
  ReactDOM.render(<Admin wpObject={window.uuc_object} />, document.getElementById('uuc-admin')); 
});
