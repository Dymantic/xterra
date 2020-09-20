<template>
    <button
        :type="role"
        :disabled="waiting"
        class="btn btn-dark relative"
        :class="btnClass"
    >
        <span :class="{ 'opacity-0': waiting, 'opacity-100': !waiting }">
            <slot></slot>
        </span>
        <span
            class="flex justify-center items-center text-center absolute inset-0"
        >
            <svg
                class="h-4 spinning text-white fill-current mr-2"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                :class="{ 'opacity-100': waiting, 'opacity-0': !waiting }"
            >
                <path
                    d="M17.584 9.372h2a9.554 9.554 0 0 0-.668-2.984L17.16 7.402c.224.623.371 1.283.424 1.97zm-3.483-8.077a9.492 9.492 0 0 0-3.086-.87v2.021a7.548 7.548 0 0 1 2.084.585l1.002-1.736zm2.141 4.327l1.741-1.005a9.643 9.643 0 0 0-2.172-2.285l-1.006 1.742a7.625 7.625 0 0 1 1.437 1.548zm-6.228 11.949a7.6 7.6 0 0 1-7.6-7.6c0-3.858 2.877-7.036 6.601-7.526V.424C4.182.924.414 5.007.414 9.971a9.6 9.6 0 0 0 9.601 9.601c4.824 0 8.807-3.563 9.486-8.2H17.48c-.658 3.527-3.748 6.199-7.466 6.199z"
                />
            </svg>
        </span>
    </button>
</template>

<script type="text/babel">
export default {
    props: {
        waiting: {
            type: Boolean,
            default: false,
        },
        mode: {
            type: String,
            default: "main",
        },
        role: {
            type: String,
            default: "submit",
        },
    },

    computed: {
        btnClass() {
            const lookup = {
                main: "btn-dark",
                danger: "btn-red",
            };

            const colors = lookup[this.mode] || "btn-dark";

            return this.waiting
                ? `${colors} opacity-75 cursor-not-allowed`
                : colors;
        },
    },
};
</script>

<style scoped lang="less">
.spinning {
    animation-name: spinning;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    animation-timing-function: ease-in-out;
}

@keyframes spinning {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
