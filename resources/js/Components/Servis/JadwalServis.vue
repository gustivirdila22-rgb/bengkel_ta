
<script setup>
import { ref, computed } from 'vue'
import {
    Search,
    Plus,
    CalendarDays,
    Clock3,
    CheckCircle2,
    Bell,
    ChevronLeft,
    ChevronRight,
    X,
    Eye,
    CarFront,
    UserRound,
    Phone,
    CalendarCheck,
    Trash2,
} from 'lucide-vue-next'

const search = ref('')
const activeFilter = ref('Semua')
const selectedDate = ref('2026-11-16')
const currentMonth = ref(new Date(2026, 10, 1))
const selectedSchedule = ref(null)
const showForm = ref(false)

const filters = ['Semua', 'Terjadwal', 'Selesai', 'Terlewat']

const schedules = ref([
    {
        id: 1,
        customer: 'Andi Pratama',
        phone: '081234567890',
        vehicle: 'Honda Vario 160',
        plate: 'AD 2345 AB',
        service: 'Servis berkala',
        date: '2026-11-16',
        time: '09:00',
        mechanic: 'Budi Santoso',
        status: 'Terjadwal',
        note: 'Pengingat servis rutin setelah ganti oli.',
    },
    {
        id: 2,
        customer: 'Dimas Saputra',
        phone: '081298765432',
        vehicle: 'Yamaha NMAX',
        plate: 'AD 4567 CD',
        service: 'Ganti oli mesin',
        date: '2026-11-16',
        time: '10:30',
        mechanic: 'Agus Setiawan',
        status: 'Terjadwal',
        note: 'Pelanggan meminta pemeriksaan kondisi oli.',
    },
    {
        id: 3,
        customer: 'Rizky Maulana',
        phone: '082123456789',
        vehicle: 'Honda Beat',
        plate: 'AD 7890 EF',
        service: 'Pemeriksaan rem',
        date: '2026-11-17',
        time: '08:30',
        mechanic: 'Budi Santoso',
        status: 'Terjadwal',
        note: 'Periksa kampas rem depan dan belakang.',
    },
    {
        id: 4,
        customer: 'Fajar Nugroho',
        phone: '085123456789',
        vehicle: 'Yamaha Aerox',
        plate: 'AD 1122 GH',
        service: 'Servis CVT',
        date: '2026-11-17',
        time: '13:00',
        mechanic: 'Agus Setiawan',
        status: 'Terjadwal',
        note: 'Pembersihan dan pemeriksaan CVT.',
    },
    {
        id: 5,
        customer: 'Agus Widodo',
        phone: '087812345678',
        vehicle: 'Honda Scoopy',
        plate: 'AD 3344 IJ',
        service: 'Ganti oli mesin',
        date: '2026-11-15',
        time: '09:00',
        mechanic: 'Budi Santoso',
        status: 'Selesai',
        note: 'Servis sudah diselesaikan.',
    },
    {
        id: 6,
        customer: 'Rian Firmansyah',
        phone: '081345678901',
        vehicle: 'Honda PCX',
        plate: 'AD 5566 KL',
        service: 'Servis berkala',
        date: '2026-11-14',
        time: '10:00',
        mechanic: 'Agus Setiawan',
        status: 'Terlewat',
        note: 'Pelanggan belum datang sesuai jadwal.',
    },
    {
        id: 7,
        customer: 'Bayu Ramadhan',
        phone: '082234567890',
        vehicle: 'Yamaha Mio',
        plate: 'AD 7788 MN',
        service: 'Pemeriksaan mesin',
        date: '2026-11-18',
        time: '11:00',
        mechanic: 'Belum ditentukan',
        status: 'Terjadwal',
        note: 'Periksa suara mesin.',
    },
])

const newSchedule = ref({
    customer: '',
    phone: '',
    vehicle: '',
    plate: '',
    service: '',
    date: '2026-11-16',
    time: '09:00',
    mechanic: '',
    note: '',
})

const filteredSchedules = computed(() => {
    const keyword = search.value.toLowerCase().trim()

    return schedules.value.filter(item => {
        const matchSearch = [
            item.customer,
            item.vehicle,
            item.plate,
            item.service,
            item.mechanic,
        ].some(value => value.toLowerCase().includes(keyword))

        const matchFilter =
            activeFilter.value === 'Semua' ||
            item.status === activeFilter.value

        return matchSearch && matchFilter
    }).sort((a, b) => {
        return `${a.date} ${a.time}`.localeCompare(`${b.date} ${b.time}`)
    })
})

const selectedDateSchedules = computed(() =>
    filteredSchedules.value.filter(item => item.date === selectedDate.value)
)

const summary = computed(() => ({
    total: schedules.value.length,
    upcoming: schedules.value.filter(item => item.status === 'Terjadwal').length,
    completed: schedules.value.filter(item => item.status === 'Selesai').length,
    missed: schedules.value.filter(item => item.status === 'Terlewat').length,
}))

const monthLabel = computed(() =>
    currentMonth.value.toLocaleDateString('id-ID', {
        month: 'long',
        year: 'numeric',
    })
)

const calendarDays = computed(() => {
    const year = currentMonth.value.getFullYear()
    const month = currentMonth.value.getMonth()
    const firstDay = new Date(year, month, 1).getDay()
    const totalDays = new Date(year, month + 1, 0).getDate()

    const days = []

    for (let i = 0; i < firstDay; i++) {
        days.push(null)
    }

    for (let day = 1; day <= totalDays; day++) {
        const date = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`

        days.push({
            day,
            date,
            count: schedules.value.filter(item => item.date === date).length,
        })
    }

    return days
})

const formatDate = date => {
    if (!date) return '-'

    return new Date(`${date}T00:00:00`).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    })
}

const statusClass = status => {
    const classes = {
        Terjadwal: 'border-blue-200 bg-blue-50 text-blue-700',
        Selesai: 'border-emerald-200 bg-emerald-50 text-emerald-700',
        Terlewat: 'border-rose-200 bg-rose-50 text-rose-700',
    }

    return classes[status] || 'border-slate-200 bg-slate-50 text-slate-600'
}

const changeMonth = amount => {
    currentMonth.value = new Date(
        currentMonth.value.getFullYear(),
        currentMonth.value.getMonth() + amount,
        1,
    )
}

const selectCalendarDate = date => {
    if (!date) return
    selectedDate.value = date
}

const saveSchedule = () => {
    if (
        !newSchedule.value.customer.trim() ||
        !newSchedule.value.vehicle.trim() ||
        !newSchedule.value.plate.trim() ||
        !newSchedule.value.service.trim() ||
        !newSchedule.value.date
    ) {
        alert('Lengkapi data pelanggan, kendaraan, jenis servis, dan tanggal.')
        return
    }

    schedules.value.push({
        id: Date.now(),
        ...newSchedule.value,
        status: 'Terjadwal',
        mechanic: newSchedule.value.mechanic || 'Belum ditentukan',
    })

    selectedDate.value = newSchedule.value.date
    currentMonth.value = new Date(
        Number(newSchedule.value.date.slice(0, 4)),
        Number(newSchedule.value.date.slice(5, 7)) - 1,
        1,
    )

    newSchedule.value = {
        customer: '',
        phone: '',
        vehicle: '',
        plate: '',
        service: '',
        date: '2026-11-16',
        time: '09:00',
        mechanic: '',
        note: '',
    }

    showForm.value = false
    activeFilter.value = 'Semua'
}

const changeStatus = (item, status) => {
    item.status = status
    selectedSchedule.value = null
}

const deleteSchedule = item => {
    if (!confirm('Yakin ingin menghapus jadwal servis ini?')) return

    schedules.value = schedules.value.filter(
        schedule => schedule.id !== item.id
    )

    selectedSchedule.value = null
}
</script>

<template>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-800">
                    Jadwal Servis
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Atur jadwal perawatan kendaraan dan pengingat pelanggan.
                </p>
            </div>

            <button
                @click="showForm = true"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800"
            >
                <Plus :size="18" />
                Tambah Jadwal
            </button>
        </div>

        <!-- Summary -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Jadwal</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-800">
                            {{ summary.total }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <CalendarDays :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Semua catatan jadwal</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Terjadwal</p>
                        <h2 class="mt-2 text-2xl font-bold text-blue-600">
                            {{ summary.upcoming }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                        <Clock3 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Menunggu kedatangan pelanggan</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Selesai</p>
                        <h2 class="mt-2 text-2xl font-bold text-emerald-700">
                            {{ summary.completed }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <CheckCircle2 :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Jadwal sudah terlaksana</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Terlewat</p>
                        <h2 class="mt-2 text-2xl font-bold text-rose-600">
                            {{ summary.missed }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-rose-50 p-3 text-rose-600">
                        <Bell :size="22" />
                    </div>
                </div>
                <p class="mt-3 text-sm text-slate-500">Pelanggan belum datang</p>
            </div>
        </div>

        <!-- Calendar and Schedule List -->
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-5">
            <!-- Calendar -->
            <div class="rounded-2xl border border-slate-200 bg-white p-5 xl:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">Kalender Servis</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Pilih tanggal untuk melihat jadwal.
                        </p>
                    </div>

                    <div class="flex gap-1">
                        <button
                            @click="changeMonth(-1)"
                            class="rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50"
                        >
                            <ChevronLeft :size="17" />
                        </button>
                        <button
                            @click="changeMonth(1)"
                            class="rounded-lg border border-slate-200 p-2 text-slate-600 hover:bg-slate-50"
                        >
                            <ChevronRight :size="17" />
                        </button>
                    </div>
                </div>

                <div class="mt-5 text-center text-base font-bold capitalize text-slate-800">
                    {{ monthLabel }}
                </div>

                <div class="mt-5 grid grid-cols-7 gap-1 text-center">
                    <div
                        v-for="day in ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']"
                        :key="day"
                        class="py-2 text-xs font-semibold text-slate-400"
                    >
                        {{ day }}
                    </div>

                    <button
                        v-for="(item, index) in calendarDays"
                        :key="index"
                        :disabled="!item"
                        @click="item && selectCalendarDate(item.date)"
                        class="relative flex min-h-11 flex-col items-center justify-center rounded-xl text-sm transition"
                        :class="!item
                            ? 'pointer-events-none'
                            : selectedDate === item.date
                                ? 'bg-emerald-700 font-bold text-white'
                                : 'text-slate-700 hover:bg-emerald-50'"
                    >
                        <span v-if="item">{{ item.day }}</span>

                        <span
                            v-if="item && item.count"
                            class="mt-0.5 h-1.5 w-1.5 rounded-full"
                            :class="selectedDate === item.date ? 'bg-white' : 'bg-emerald-600'"
                        />
                    </button>
                </div>

                <div class="mt-5 flex flex-wrap gap-4 border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-600" />
                        Ada jadwal
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="h-2.5 w-2.5 rounded-full bg-slate-300" />
                        Tidak ada jadwal
                    </div>
                </div>
            </div>

            <!-- Selected Date Schedule -->
            <div class="rounded-2xl border border-slate-200 bg-white xl:col-span-3">
                <div class="flex flex-col gap-2 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">
                            Jadwal Terpilih
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ formatDate(selectedDate) }}
                        </p>
                    </div>

                    <span class="w-fit rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                        {{ selectedDateSchedules.length }} Jadwal
                    </span>
                </div>

                <div class="max-h-[410px] space-y-3 overflow-y-auto p-5">
                    <div
                        v-for="item in selectedDateSchedules"
                        :key="item.id"
                        class="rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200"
                    >
                        <div class="flex items-start gap-3">
                            <div class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                                <CarFront :size="21" />
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="font-semibold text-slate-800">
                                        {{ item.customer }}
                                    </p>
                                    <span
                                        class="rounded-full border px-2.5 py-1 text-xs font-semibold"
                                        :class="statusClass(item.status)"
                                    >
                                        {{ item.status }}
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-slate-500">
                                    {{ item.vehicle }} · {{ item.plate }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-2 text-sm text-slate-500">
                                    <span class="flex items-center gap-1.5">
                                        <Clock3 :size="15" />
                                        {{ item.time }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <Wrench :size="15" />
                                        {{ item.service }}
                                    </span>
                                </div>

                                <div class="mt-3 flex justify-end">
                                    <button
                                        @click="selectedSchedule = item"
                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-700 hover:text-emerald-800"
                                    >
                                        <Eye :size="16" />
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="selectedDateSchedules.length === 0"
                        class="py-12 text-center"
                    >
                        <CalendarDays :size="32" class="mx-auto text-slate-300" />
                        <p class="mt-3 font-semibold text-slate-600">
                            Tidak ada jadwal servis
                        </p>
                        <p class="mt-1 text-sm text-slate-400">
                            Belum ada jadwal pada tanggal ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Schedule List -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <div class="border-b border-slate-100 p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">Semua Jadwal Servis</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelola seluruh jadwal dan pengingat servis pelanggan.
                        </p>
                    </div>

                    <div class="relative w-full lg:max-w-xs">
                        <Search
                            :size="18"
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                        />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari pelanggan atau kendaraan..."
                            class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        />
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    <button
                        v-for="filter in filters"
                        :key="filter"
                        @click="activeFilter = filter"
                        class="rounded-lg border px-4 py-2 text-sm font-medium transition"
                        :class="activeFilter === filter
                            ? 'border-emerald-700 bg-emerald-700 text-white'
                            : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                    >
                        {{ filter }}
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-4">Pelanggan</th>
                            <th class="px-5 py-4">Kendaraan</th>
                            <th class="px-5 py-4">Jenis Servis</th>
                            <th class="px-5 py-4">Tanggal & Jam</th>
                            <th class="px-5 py-4">Mekanik</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="item in filteredSchedules"
                            :key="item.id"
                            class="transition hover:bg-slate-50/70"
                        >
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-700">
                                    {{ item.customer }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.phone }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-700">
                                    {{ item.vehicle }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.plate }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.service }}
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-slate-700">
                                    {{ formatDate(item.date) }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ item.time }}
                                </p>
                            </td>

                            <td class="px-5 py-4 text-sm text-slate-600">
                                {{ item.mechanic }}
                            </td>

                            <td class="px-5 py-4">
                                <span
                                    class="rounded-full border px-3 py-1.5 text-xs font-semibold"
                                    :class="statusClass(item.status)"
                                >
                                    {{ item.status }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <button
                                    @click="selectedSchedule = item"
                                    class="rounded-lg border border-slate-200 p-2 text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                >
                                    <Eye :size="17" />
                                </button>
                            </td>
                        </tr>

                        <tr v-if="filteredSchedules.length === 0">
                            <td colspan="7" class="px-5 py-12 text-center text-sm text-slate-400">
                                Jadwal servis tidak ditemukan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Schedule Modal -->
        <div
            v-if="showForm"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4"
            @click.self="showForm = false"
        >
            <div class="my-auto w-full max-w-xl rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Tambah Jadwal Servis</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Masukkan informasi jadwal pelanggan.
                        </p>
                    </div>
                    <button
                        @click="showForm = false"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                    >
                        <X :size="20" />
                    </button>
                </div>

                <form @submit.prevent="saveSchedule" class="space-y-4 p-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Nama Pelanggan *
                            </label>
                            <input
                                v-model="newSchedule.customer"
                                required
                                placeholder="Nama pelanggan"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Nomor HP
                            </label>
                            <input
                                v-model="newSchedule.phone"
                                placeholder="08xxxxxxxxxx"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Kendaraan *
                            </label>
                            <input
                                v-model="newSchedule.vehicle"
                                required
                                placeholder="Contoh: Honda Vario 160"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Nomor Polisi *
                            </label>
                            <input
                                v-model="newSchedule.plate"
                                required
                                placeholder="AD 1234 AB"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm uppercase outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Jenis Servis *
                            </label>
                            <input
                                v-model="newSchedule.service"
                                required
                                placeholder="Jenis servis"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Mekanik
                            </label>
                            <input
                                v-model="newSchedule.mechanic"
                                placeholder="Nama mekanik"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Tanggal *
                            </label>
                            <input
                                v-model="newSchedule.date"
                                type="date"
                                required
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Jam
                            </label>
                            <input
                                v-model="newSchedule.time"
                                type="time"
                                class="w-full rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            Catatan
                        </label>
                        <textarea
                            v-model="newSchedule.note"
                            rows="3"
                            placeholder="Catatan tambahan untuk jadwal servis..."
                            class="w-full resize-none rounded-xl border border-slate-200 px-3 py-3 text-sm outline-none focus:border-emerald-600"
                        />
                    </div>

                    <div class="flex justify-end gap-2 border-t border-slate-100 pt-4">
                        <button
                            type="button"
                            @click="showForm = false"
                            class="rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800"
                        >
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Detail Schedule Modal -->
        <div
            v-if="selectedSchedule"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
            @click.self="selectedSchedule = null"
        >
            <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-100 p-5">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Detail Jadwal</h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Informasi jadwal servis pelanggan.
                        </p>
                    </div>
                    <button
                        @click="selectedSchedule = null"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-100"
                    >
                        <X :size="20" />
                    </button>
                </div>

                <div class="space-y-4 p-5">
                    <div class="flex items-center gap-3 rounded-xl bg-emerald-50 p-4">
                        <div class="rounded-lg bg-white p-3 text-emerald-700">
                            <CarFront :size="23" />
                        </div>
                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ selectedSchedule.vehicle }}
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                {{ selectedSchedule.plate }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-400">Pelanggan</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedSchedule.customer }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Nomor HP</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedSchedule.phone || '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Tanggal</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ formatDate(selectedSchedule.date) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Jam</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedSchedule.time }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Jenis Servis</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedSchedule.service }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Mekanik</p>
                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ selectedSchedule.mechanic }}
                            </p>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-xs text-slate-400">Catatan</p>
                        <p class="mt-1 text-sm text-slate-700">
                            {{ selectedSchedule.note || 'Tidak ada catatan.' }}
                        </p>
                    </div>

                    <div>
                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Ubah Status
                        </p>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                v-for="status in filters.slice(1)"
                                :key="status"
                                @click="changeStatus(selectedSchedule, status)"
                                class="rounded-lg border px-2 py-2.5 text-xs font-semibold transition"
                                :class="selectedSchedule.status === status
                                    ? 'border-emerald-700 bg-emerald-700 text-white'
                                    : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                            >
                                {{ status }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 border-t border-slate-100 p-5">
                    <button
                        @click="deleteSchedule(selectedSchedule)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 hover:bg-rose-50"
                    >
                        <Trash2 :size="17" />
                        Hapus
                    </button>
                    <button
                        @click="selectedSchedule = null"
                        class="flex-1 rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
