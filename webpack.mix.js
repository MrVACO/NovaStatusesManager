let mix = require('laravel-mix')

require('./nova.mix')

mix
    .setPublicPath('dist')
    .js('resources/js/status-field.js', 'js')
    .vue({ version: 3 })
    .nova('mr-vaco/nova-statuses-manager')
    .disableNotifications()
