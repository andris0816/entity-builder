<script setup lang="ts">
import {computed, onBeforeUnmount, onMounted, ref} from "vue";

interface Props {
    disabled?: boolean;
    modelValue: string | number | null;
    customClass?: string;
    label?: string;
    error?: string;
    placeholder?: string;
    items: (string | {id: number; name: string })[]
}

const isOpen = ref(false);

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
    customClass: '',
    placeholder: 'Select an item',
});

const emit = defineEmits<{
    'update:modelValue': [value: string | number | null]
}>();

const value = computed({
    get: () => props.modelValue,
    set: (value: string) => emit('update:modelValue', value)
});

const inputClasses = [
    'selection:bg-primary',
    'selection:text-primary-foreground',
    'flex',
    'items-center',
    'justify-between',
    'gap-2',
    'h-9',
    'w-full',
    'min-w-0',
    'rounded-md',
    'border',
    'px-3',
    'py-1',
    'text-base',
    'cursor-pointer',
    '[&_svg]:pointer-events-none',
    '[&_svg]:shrink-0',
    '[&_svg:not([class*=\'size-\'])]:size-4',
    '*:data-[slot=select-value]:line-clamp-1',
    '*:data-[slot=select-value]:flex',
    '*:data-[slot=select-value]:items-center',
    '*:data-[slot=select-value]:gap-2',
    '[&_svg:not([class*=\'text-\'])]:text-muted-foreground',
    'transition-[color,box-shadow]',
    'outline-none',
    'disabled:pointer-events-none',
    'disabled:cursor-not-allowed',
    'disabled:opacity-50',
    'md:text-sm',
    'focus-visible:border-gray-500',
    'focus-visible:ring-gray-500/40',
    'focus-visible:ring-[3px]',
    'aria-invalid:ring-destructive',
    'aria-invalid:border-destructive',
    'bg-gray-950/80',
    'border-gray-700',
    'text-white',
    'placeholder:text-gray-500',
    'mt-1'
];

const selectItem = (item: string | { id: number; name: string }) => {
    const val = typeof item === 'string' ? item : item.id;
    emit('update:modelValue', val);
    isOpen.value = false;
};

function onClickOutside(event: MouseEvent) {
    const target = event.target as HTMLElement;
    if (!target.closest('.custom-select')) {
        isOpen.value = false;
    }
}

const selectedLabel = computed(() => {
    const current = props.items.find(i =>
        typeof i === 'string'
            ? i === props.modelValue
            : i.id === props.modelValue
    );
    return typeof current === 'string'
        ? current
        : current?.name ?? props.placeholder ?? '';
});

onMounted(() => document.addEventListener('click', onClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', onClickOutside));
</script>

<template>
    <div class="custom-select relative">
        <label v-if="label" class="block space-y-2 text-gray-300 text-sm font-medium">
            {{ label }}
        </label>

        <button
            type="button"
            @click="! disabled && (isOpen = !isOpen)"
            :class="inputClasses"
        >
            <span data-slot="select-value" style="pointer-events: none;">{{ selectedLabel }}</span>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="lucide lucide-chevron-down size-4 opacity-50"
                aria-hidden="true"
            >
                <path d="m6 9 6 6 6-6"></path>
            </svg>
        </button>

        <ul
            v-if="isOpen"
            class="absolute z-10 mt-1 w-full max-h-60 overflow-auto rounded-md border
             border-gray-700 bg-gray-800 shadow-lg text-gray-100"
        >
            <li
                v-for="item in items"
                :key="typeof item === 'string' ? item : item.id"
                @click="selectItem(item)"
                :class="['cursor-pointer px-3 py-2 hover:bg-blue-600 hover:text-white',
                        value === item ? 'bg-blue-600' : '']"
            >
                {{ typeof item === 'string' ? item : item.name }}
            </li>
        </ul>

        <div v-if="error" class="text-sm text-red-500 mt-1">
            {{ error }}
        </div>
    </div>
</template>

<style scoped>

</style>
