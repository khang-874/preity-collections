import './bootstrap';
import './JsBarcode.all.min';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

Alpine.plugin(persist)

window.Alpine= Alpine;
Alpine.start()

