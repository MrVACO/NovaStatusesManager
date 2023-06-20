<template>
    <PanelItem
        :index="index"
        :field="field"
        :fieldName="fieldName"
    >
        <template #value>
            <p class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     :fill="field.status.color ?? 'black'"
                     viewBox="0 0 24 24"
                     width="24"
                     height="24"
                     class="inline-block"
                >
                    <circle cx="12" cy="12" r="4" />
                </svg>

                <span :style="`color:` + field.status.color ?? 'black'">
                    {{ field.status.name ?? field.value }}
                </span>
            </p>
        </template>
    </PanelItem>
</template>

<script>
export default {
    props: {
        index: {
            type: Number,
            required: true,
        },

        field: {
            type: Object,
            required: true,
        },

        fieldName: {
            type: String,
            default: '',
        },
    },

    computed: {
        label() {
            return this.fieldName || this.field.name
        }
    },
}
</script>
