import forms from '@tailwindcss/forms';

// Verdant UI's own form components (inputs, selects, checkboxes) already ship
// fully styled via their own `v-` prefixed classes. The default 'base' strategy
// applies a global, unscoped reset to every native <input>/<select>/<textarea>
// on the page, which fights with verdant's styling (e.g. an invisible checkbox
// tick, since verdant's unlayered CSS wins the background-color but the forms
// plugin's layered background-image still draws). 'class' scopes the plugin to
// elements that explicitly opt in (e.g. `class="form-input"`), leaving verdant's
// own components untouched while keeping the plugin available for raw HTML.
export default forms({ strategy: 'class' });
