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
                @change="handleChange"
                class="w-full"
                :select-classes="{ 'form-input-border-error': hasError }"
                :options="currentField.options"
                :disabled="currentlyIsReadonly"
            >
                <option value="" selected :disabled="!currentField.nullable">
                    {{ placeholder }}
                </option>
            </SelectControl>
        </template>
    </DefaultField>
</template>

<script>
import find from 'lodash/find'
import first from 'lodash/first'
import isNil from 'lodash/isNil'
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    data: () => ({
        selectedOption: null,
        value: null,
    }),

    created() {
        if (this.field.value) {
            let selectedOption = find(
                this.field.options,
                v => v.value == this.field.value
            )
            this.$nextTick(() => {
                this.selectOption(selectedOption)
            })
        }
    },

    methods: {
        fill(formData) {
            this.fillIfVisible(formData, this.field.attribute, this.value ?? '')
        },

        clearSelection() {
            this.selectedOption = ''
            this.value = ''

            if (this.field) {
                this.emitFieldValueChange(this.field.attribute, this.value)
            }
        },

        selectOption(option) {
            if (isNil(option)) {
                this.clearSelection()
                return
            }

            this.selectedOption = option
            this.value = option.value

            if (this.field) {
                this.emitFieldValueChange(this.field.attribute, this.value)
            }
        },

        handleChange(value) {
            let selectedOption = find(
                this.currentField.options,
                v => v.value == value
            )

            this.selectOption(selectedOption)
        },

        onSyncedField() {
            let currentSelectedOption = null
            let hasValue = false

            if (this.selectedOption) {
                hasValue = true

                currentSelectedOption = find(
                    this.currentField.options,
                    v => v.value == this.selectedOption.value
                )
            }

            let selectedOption = find(
                this.currentField.options,
                v => v.value == this.currentField.value
            )

            if (isNil(currentSelectedOption)) {
                this.clearSelection()

                if (this.currentField.value) {
                    this.selectOption(selectedOption)
                } else if (hasValue && !this.currentField.nullable) {
                    this.selectOption(first(this.currentField.options))
                }
                return
            } else if (
                currentSelectedOption && selectedOption && ['create', 'attach'].includes(this.editMode)
            ) {
                this.selectOption(selectedOption)
                return
            }

            this.selectOption(currentSelectedOption)
        },
    },
    computed: {
        placeholder() {
            return this.currentField.placeholder || this.__('Choose an option')
        },

        hasValue() {
            return Boolean(
                !(this.value === undefined || this.value === null || this.value === '')
            )
        },
    },
}
</script>
