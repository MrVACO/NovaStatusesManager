<template>
    <DefaultField
        :field="currentField"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <SelectControl
                :id="field.attribute"
                :dusk="field.attribute"
                v-model:selected="value"
                :select-classes="{ 'form-input-border-error': hasError }"
                :disabled="currentlyIsReadonly"
            >
                <option value="" selected :disabled="!currentField.nullable">
                    {{ placeholder }}
                </option>

                <option
                    v-for="option in currentField.options"
                    :key="option.value"
                    :value="option.value"
                >
                    {{ option.label }}
                </option>
            </SelectControl>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    data: () => ({
        selectedOption: null,
        value: null,
    }),

    methods: {
        fill(formData) {
            this.fillIfVisible(formData, this.field.attribute, this.value ?? '')
        },
    },

    computed: {
        placeholder() {
            return this.currentField.placeholder || this.__('Choose an option')
        },
    },
}
</script>
