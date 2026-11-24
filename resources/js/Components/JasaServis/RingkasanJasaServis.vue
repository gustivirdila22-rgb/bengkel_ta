
<script setup>
import { Wrench, CircleCheck, Tags } from 'lucide-vue-next'

defineProps({
    ringkasan: {
        type: Object,
        default: () => ({
            total: 0,
            aktif: 0,
            nonaktif: 0,
            totalKategori: 0,
            kategoriDipakai: 0,
        }),
    },
})
</script>

<template>
    <div class="mb-5 flex flex-wrap gap-2">

        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
            <div class="flex items-center gap-2">
                <Wrench :size="16" class="text-slate-400" />
                <span class="text-sm font-bold text-slate-800">
                    {{ ringkasan.total }}
                </span>
                <span class="text-sm text-slate-500">
                    jasa servis
                </span>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
            <div class="flex items-center gap-2">
                <CircleCheck :size="16" class="text-emerald-500" />
                <span class="text-sm font-bold text-slate-800">
                    {{ ringkasan.aktif }}
                </span>
                <span class="text-sm text-slate-500">
                    masih dipakai
                </span>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5">
            <div class="flex items-center gap-2">
                <Tags :size="16" class="text-slate-400" />
                <span class="text-sm font-bold text-slate-800">
                    {{ ringkasan.totalKategori }}
                </span>
                <span class="text-sm text-slate-500">
                    kategori
                </span>
            </div>
        </div>

    </div>
</template>
