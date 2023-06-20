<template>
    <p>
        <svg xmlns="http://www.w3.org/2000/svg"
             :fill="this.field.status.color ?? 'black'"
             viewBox="0 0 24 24"
             width="24"
             height="24"
             class="inline-block"
        >
            <circle cx="12" cy="12" r="4" />
        </svg>

        <span
            :style="`color:` + this.field.status.color ?? 'black'"
        >
        {{ this.field.status.name ?? this.field.value }}
        </span>
    </p>
</template>

<script>
export default {
    props: ['resourceName', 'field']
}
</script>
