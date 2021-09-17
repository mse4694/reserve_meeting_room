//require('./bootstrap');
window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { RouterLink } from 'vue-router';
import mitt from 'mitt';

const emitter = mitt();

import PrimeVue from 'primevue/config';
import AutoComplete from 'primevue/autocomplete';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Avatar from 'primevue/avatar';
import AvatarGroup from 'primevue/avatargroup';
import Badge from 'primevue/badge';
import BadgeDirective from "primevue/badgedirective";
import BlockUI from 'primevue/blockui';
import Breadcrumb from 'primevue/breadcrumb';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Card from 'primevue/card';
import CascadeSelect from 'primevue/cascadeselect';
import Carousel from 'primevue/carousel';
import Checkbox from 'primevue/checkbox';
import Chip from 'primevue/chip';
import Chips from 'primevue/chips';
import ColorPicker from 'primevue/colorpicker';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmPopup from 'primevue/confirmpopup';
import ContextMenu from 'primevue/contextmenu';
import DataTable from 'primevue/datatable';
import DataView from 'primevue/dataview';
import DataViewLayoutOptions from 'primevue/dataviewlayoutoptions';
import DeferredContent from 'primevue/deferredcontent';
import Dialog from 'primevue/dialog';
import Divider from 'primevue/divider';
import Dock from 'primevue/dock';
import Dropdown from 'primevue/dropdown';
import Fieldset from 'primevue/fieldset';
import FileUpload from 'primevue/fileupload';
import FullCalendar from 'primevue/fullcalendar';
import Galleria from 'primevue/galleria';
import InlineMessage from 'primevue/inlinemessage';
import Inplace from 'primevue/inplace';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import InputNumber from 'primevue/inputnumber';
import Knob from 'primevue/knob';
import Listbox from 'primevue/listbox';
import MegaMenu from 'primevue/megamenu';
import Menu from 'primevue/menu';
import Menubar from 'primevue/menubar';
import Message from 'primevue/message';
import MultiSelect from 'primevue/multiselect';
import OrderList from 'primevue/orderlist';
import OrganizationChart from 'primevue/organizationchart';
import OverlayPanel from 'primevue/overlaypanel';
import Paginator from 'primevue/paginator';
import Panel from 'primevue/panel';
import PanelMenu from 'primevue/panelmenu';
import Password from 'primevue/password';
import PickList from 'primevue/picklist';
import ProgressBar from 'primevue/progressbar';
import ProgressSpinner from 'primevue/progressspinner';
import Rating from 'primevue/rating';
import RadioButton from 'primevue/radiobutton';
import Ripple from 'primevue/ripple';
import Row from 'primevue/row';
import SelectButton from 'primevue/selectbutton';
import ScrollPanel from 'primevue/scrollpanel';
import ScrollTop from 'primevue/scrolltop';
import Skeleton from 'primevue/skeleton';
import Slider from 'primevue/slider';
import Sidebar from 'primevue/sidebar';
import SpeedDial from 'primevue/speeddial';
import SplitButton from 'primevue/splitbutton';
import Splitter from 'primevue/splitter';
import SplitterPanel from 'primevue/splitterpanel';
import Steps from 'primevue/steps';
import TabMenu from 'primevue/tabmenu';
import TieredMenu from 'primevue/tieredmenu';
import Textarea from 'primevue/textarea';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Toolbar from 'primevue/toolbar';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Tag from 'primevue/tag';
import Terminal from 'primevue/terminal';
import Timeline from 'primevue/timeline';
import ToggleButton from 'primevue/togglebutton';
import Tooltip from 'primevue/tooltip';
import Tree from 'primevue/tree';
import TreeSelect from 'primevue/treeselect';
import TreeTable from 'primevue/treetable';
import TriStateCheckbox from 'primevue/tristatecheckbox';
import VirtualScroller from 'primevue/virtualscroller';

import 'primevue/resources/themes/tailwind-light/theme.css';
//import 'primevue/resources/themes/saga-blue/theme.css';   // theme
//import 'primevue/resources/themes/vela-blue/theme.css';   // theme
//import 'primevue/resources/themes/nova/theme.css';          // theme

import 'primevue/resources/primevue.min.css';             // core css
import 'primeicons/primeicons.css';                       // icons

import AppLayout from '@/Layouts/AppLayout.vue';

//InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(PrimeVue, {
        locale: {
          startsWith: 'Starts with',
          contains: 'Contains',
          notContains: 'Not contains',
          endsWith: 'Ends with',
          equals: 'Equals',
          notEquals: 'Not equals',
          noFilter: 'No Filter',
          lt: 'Less than',
          lte: 'Less than or equal to',
          gt: 'Greater than',
          gte: 'Greater than or equal to',
          dateIs: 'Date is',
          dateIsNot: 'Date is not',
          dateBefore: 'Date is before',
          dateAfter: 'Date is after',
          clear: 'ล้างข้อมูล',
          apply: 'Apply',
          matchAll: 'Match All',
          matchAny: 'Match Any',
          addRule: 'Add Rule',
          removeRule: 'Remove Rule',
          accept: 'Yes',
          reject: 'No',
          choose: 'Choose',
          upload: 'Upload',
          cancel: 'Cancel',
          dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
          dayNamesShort: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
          dayNamesMin: ["อา.", "จ.", "อ.", "พ.", "พฤ.", "ศ.", "ส."],
          monthNames: ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"],
          monthNamesShort: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.","ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
          today: 'วันนี้',
          weekHeader: 'Wk',
          firstDayOfWeek: 0,
          dateFormat: 'dd/mm/yy',
          weak: 'Weak',
          medium: 'Medium',
          strong: 'Strong',
          passwordPrompt: 'Enter a password',
          emptyFilterMessage: 'No results found',
          emptyMessage: 'No available options'
        },
    })
    //.use(ZiggyVue, Ziggy)
    .use(ToastService)
    //.use(Vuelidate)
    .directive('tooltip', Tooltip)
    .directive('badge', BadgeDirective)
    .directive('ripple', Ripple)
    .component('RouterLink', RouterLink)
    .component('Accordion', Accordion)
    .component('AccordionTab', AccordionTab)
    .component('AutoComplete', AutoComplete)
    .component('Avatar', Avatar)
    .component('AvatarGroup', AvatarGroup)
    .component('Badge', Badge)
    .component('BlockUI', BlockUI)
    .component('Breadcrumb', Breadcrumb)
    .component('Button', Button)
    .component('Calendar', Calendar)
    .component('Card', Card)
    .component('Carousel', Carousel)
    .component('CascadeSelect', CascadeSelect)
    .component('Checkbox', Checkbox)
    .component('Chip', Chip)
    .component('Chips', Chips)
    .component('ColorPicker', ColorPicker)
    .component('Column', Column)
    .component('ColumnGroup', ColumnGroup)
    .component('ConfirmDialog', ConfirmDialog)
    .component('ConfirmPopup', ConfirmPopup)
    .component('ContextMenu', ContextMenu)
    .component('DataTable', DataTable)
    .component('DataView', DataView)
    .component('DataViewLayoutOptions', DataViewLayoutOptions)
    .component('DeferredContent', DeferredContent)
    .component('Dialog', Dialog)
    .component('Divider', Divider)
    .component('Dock', Dock)
    .component('Dropdown', Dropdown)
    .component('Fieldset', Fieldset)
    .component('FileUpload', FileUpload)
    .component('FullCalendar', FullCalendar)
    .component('InlineMessage', InlineMessage)
    .component('Inplace', Inplace)
    .component('InputMask', InputMask)
    .component('InputNumber', InputNumber)
    .component('InputSwitch', InputSwitch)
    .component('InputText', InputText)
    .component('Galleria', Galleria)
    .component('Knob', Knob)
    .component('Listbox', Listbox)
    .component('MegaMenu', MegaMenu)
    .component('Menu', Menu)
    .component('Menubar', Menubar)
    .component('Message', Message)
    .component('MultiSelect', MultiSelect)
    .component('OrderList', OrderList)
    .component('OrganizationChart', OrganizationChart)
    .component('OverlayPanel', OverlayPanel)
    .component('Paginator', Paginator)
    .component('Panel', Panel)
    .component('PanelMenu', PanelMenu)
    .component('Password', Password)
    .component('PickList', PickList)
    .component('ProgressBar', ProgressBar)
    .component('ProgressSpinner', ProgressSpinner)
    .component('RadioButton', RadioButton)
    .component('Rating', Rating)
    .component('Row', Row)
    .component('SelectButton', SelectButton)
    .component('ScrollPanel', ScrollPanel)
    .component('ScrollTop', ScrollTop)
    .component('Slider', Slider)
    .component('Sidebar', Sidebar)
    .component('Skeleton', Skeleton)
    .component('SpeedDial', SpeedDial)
    .component('SplitButton', SplitButton)
    .component('Splitter', Splitter)
    .component('SplitterPanel', SplitterPanel)
    .component('Steps', Steps)
    .component('TabMenu', TabMenu)
    .component('TabView', TabView)
    .component('TabPanel', TabPanel)
    .component('Tag', Tag)
    .component('Textarea', Textarea)
    .component('Terminal', Terminal)
    .component('TieredMenu', TieredMenu)
    .component('Timeline', Timeline)
    .component('Toast', Toast)
    .component('Toolbar', Toolbar)
    .component('ToggleButton', ToggleButton)
    .component('Tree', Tree)
    .component('TreeSelect', TreeSelect)
    .component('TreeTable', TreeTable)
    .component('TriStateCheckbox', TriStateCheckbox)
    .component('VirtualScroller', VirtualScroller)
    .component('AppLayout', AppLayout)
    .mixin({ methods: { route: window.route } }) // enable route() on template
    .provide('emitter', emitter)
    .mount(el)
  },
})

InertiaProgress.init({ color: '#4B5563' });