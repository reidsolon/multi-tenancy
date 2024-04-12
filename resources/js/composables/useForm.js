import assignIn from 'lodash/assignIn'
import cloneDeep from 'lodash/cloneDeep'
import each from 'lodash/each'
import {reactive} from "vue";

class Form {
    constructor(values) {
        this.$errors = {}
        this.$busy = false
        this.$originalData = cloneDeep(values)
        assignIn(this, values)
    }

    /**
     * Returns the values based on original fields
     *
     * @returns {Object}
     */
    $data() {
        let data = cloneDeep(this.$originalData)
        each(this.$originalData, (_, key) => {
            data[key] = this[key]
        })

        return data
    }

    /**
     * Reset the form to its original phase
     * Set the original data values
     * Clear errors
     */
    $reset() {
        assignIn(this, this.$originalData)
        this.$clearErrors()
    }

    /**
     * Set the form errors
     * @param {Object, Array} errors
     */
    $setErrors(errors) {
        this.$errors = errors
    }

    $hasErrors() {
        return !!(this.$errors.fields || this.$errors.title)
    }

    /**
     * Clear all form errors
     */
    $clearErrors() {
        this.$errors = {}
    }

    /**
     * Clear the errors in a specific field
     *
     * @param {String} field
     */
    $clearError(field) {
        delete this.$errors[field]
    }

    /**
     * Check if the field has error
     *
     * @param {String} field
     * @returns {Boolean}
     */
    $hasError(field) {
        return !!this.$errors[field]
    }

    /**
     * Get the error description of a specific field
     *
     * @param {String} field
     * @returns {String}
     */
    $getError(field) {
        return this.$errors[field]
    }
}

export function useForm(data) {
    return reactive(new Form(data));
}
