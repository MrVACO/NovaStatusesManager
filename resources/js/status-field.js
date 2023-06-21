import StatusIndexField from "./components/StatusIndexField";
import StatusDetailField from "./components/StatusDetailField";
import StatusFormField from "./components/StatusFormField";

Nova.booting((app, store) => {
    app.component('index-status-field', StatusIndexField)
    app.component('detail-status-field', StatusDetailField)
    app.component('form-status-field', StatusFormField)
})
