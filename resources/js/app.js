import './bootstrap';

import {
    Collapse,
    Tab,
    Dropdown,
    Ripple,
    initTWE,
  } from "tw-elements";



  initTWE({ Collapse });
  initTWE({ Tab });
  initTWE({ Dropdown, Ripple });

  import jQuery from 'jquery';
  window.$ = jQuery;
