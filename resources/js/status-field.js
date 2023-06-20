import StatusIndexField from "./components/StatusIndexField";
import StatusDetailField from "./components/StatusDetailField";

Nova.booting((app, store) => {
    app.component('index-status-field', StatusIndexField)
    app.component('detail-status-field', StatusDetailField)
})
