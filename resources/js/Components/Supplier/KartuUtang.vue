
<script setup>
import { ref, computed } from 'vue'
import {
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    CalendarDays,
} from 'lucide-vue-next'

const modeTampilan = ref('supplier')
const supplierTerpilih = ref('SUP-D02')
const bulanAktif = ref(new Date(2026, 10, 1))
const jumlahPerHalaman = ref(50)
const halamanAktif = ref(1)

const suppliers = [
    {
        kode: 'SUP-D01',
        nama: 'Toko Sparepart Jaya Motor',
        saldoAwal: 18259500,
    },
    {
        kode: 'SUP-D02',
        nama: 'Agen Oli Makmur Sentosa',
        saldoAwal: 51984500,
    },
    {
        kode: 'SUP-D03',
        nama: 'Sumber Rem & Kaki-kaki',
        saldoAwal: 1770000,
    },
    {
        kode: 'SUP-D04',
        nama: 'Elektrik Mobil Nusantara',
        saldoAwal: 40044000,
    },
    {
        kode: 'SUP-D05',
        nama: 'Grosir Aksesoris Otomotif',
        saldoAwal: 195000,
    },
]

const dataUtang = [
    {
        supplier: 'SUP-D01',
        tanggal: '03 November 2026',
        bukti: 'BYR-000470',
        keterangan: 'Pembayaran utang pembelian',
        subKeterangan: 'Utang dibayar',
        masuk: 0,
        dibayar: 2500000,
    },
    {
        supplier: 'SUP-D02',
        tanggal: '02 November 2026',
        bukti: 'BYR-000473',
        keterangan: 'Pembayaran atas HT-000106',
        subKeterangan: 'Utang dibayar',
        masuk: 0,
        dibayar: 6000000,
    },
    {
        supplier: 'SUP-D03',
        tanggal: '05 November 2026',
        bukti: 'HT-000108',
        keterangan: 'Pembelian sparepart',
        subKeterangan: 'Utang baru',
        masuk: 1770000,
        dibayar: 0,
    },
    {
        supplier: 'SUP-D04',
        tanggal: '08 November 2026',
        bukti: 'HT-000109',
        keterangan: 'Pembelian komponen kelistrikan',
        subKeterangan: 'Utang baru',
        masuk: 4000000,
        dibayar: 0,
    },
    {
        supplier: 'SUP-D05',
        tanggal: '10 November 2026',
        bukti: 'BYR-000475',
        keterangan: 'Pembayaran pembelian aksesoris',
        subKeterangan: 'Utang dibayar',
        masuk: 0,
        dibayar: 195000,
    },
]

const formatRupiah = (angka) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
    }).format(angka)
}

const namaBulan = computed(() => {
    return bulanAktif.value.toLocaleDateString('id-ID', {
        month: 'long',
        year: 'numeric',
    })
})

const semuaSupplier = computed(() => modeTampilan.value === 'semua')

const supplierData = computed(() => {
    return suppliers.find(item => item.kode === supplierTerpilih.value)
})

const supplierDitampilkan = computed(() => {
    if (semuaSupplier.value) return suppliers

    return suppliers.filter(
        item => item.kode === supplierTerpilih.value
    )
})

const dataTerfilter = computed(() => {
    if (semuaSupplier.value) {
        return dataUtang
    }

    return dataUtang.filter(
        item => item.supplier === supplierTerpilih.value
    )
})

const ringkasan = computed(() => {
    const daftarSupplier = supplierDitampilkan.value
    const daftarTransaksi = dataTerfilter.value

    const awal = daftarSupplier.reduce(
        (total, item) => total + item.saldoAwal,
        0
    )

    const masuk = daftarTransaksi.reduce(
        (total, item) => total + item.masuk,
        0
    )

    const dibayar = daftarTransaksi.reduce(
        (total, item) => total + item.dibayar,
        0
    )

    return {
        awal,
        masuk,
        dibayar,
        akhir: awal + masuk - dibayar,
    }
})

const dataTabel = computed(() => {
    const rows = []

    if (semuaSupplier.value) {
        supplierDitampilkan.value.forEach(supplier => {
            rows.push({
                tipe: 'awal',
                supplier: supplier.kode,
                tanggal: '',
                bukti: '',
                keterangan: 'Utang aktif awal bulan',
                masuk: null,
                dibayar: null,
                aktif: supplier.saldoAwal,
            })
        })
    } else {
        rows.push({
            tipe: 'awal',
            supplier: supplierTerpilih.value,
            tanggal: '',
            bukti: '',
            keterangan: 'Utang aktif awal bulan',
            masuk: null,
            dibayar: null,
            aktif: supplierData.value?.saldoAwal ?? 0,
        })
    }

    dataTerfilter.value.forEach(item => {
        const supplier = suppliers.find(
            s => s.kode === item.supplier
        )

        const transaksiSebelumnya = dataTerfilter.value
            .filter(t =>
                t.supplier === item.supplier &&
                dataTerfilter.value.indexOf(t) <= dataTerfilter.value.indexOf(item)
            )

        const saldoAwal = suppliers.find(
            s => s.kode === item.supplier
        )?.saldoAwal ?? 0

        const saldo = saldoAwal + transaksiSebelumnya.reduce(
            (total, t) => total + t.masuk - t.dibayar,
            0
        )

        rows.push({
            ...item,
            tipe: 'transaksi',
            namaSupplier: supplier?.nama ?? '',
            aktif: saldo,
        })
    })

    rows.push({
        tipe: 'total',
        tanggal: '',
        bukti: '',
        keterangan: `Total ${namaBulan.value}`,
        masuk: ringkasan.value.masuk,
        dibayar: ringkasan.value.dibayar,
        aktif: ringkasan.value.akhir,
    })

    return rows
})

const totalData = computed(() => dataTabel.value.length)

const totalHalaman = computed(() => {
    return Math.max(
        1,
        Math.ceil(totalData.value / jumlahPerHalaman.value)
    )
})

const dataHalaman = computed(() => {
    const start = (halamanAktif.value - 1) * jumlahPerHalaman.value

    return dataTabel.value.slice(
        start,
        start + jumlahPerHalaman.value
    )
})

const dataMulai = computed(() => {
    return totalData.value === 0
        ? 0
        : (halamanAktif.value - 1) * jumlahPerHalaman.value + 1
})

const dataSampai = computed(() => {
    return Math.min(
        halamanAktif.value * jumlahPerHalaman.value,
        totalData.value
    )
})

const gantiBulan = (arah) => {
    const tanggal = new Date(bulanAktif.value)
    tanggal.setMonth(tanggal.getMonth() + arah)
    bulanAktif.value = tanggal
    halamanAktif.value = 1
}

const pilihMode = (mode) => {
    modeTampilan.value = mode
    halamanAktif.value = 1
}

const pilihSupplier = () => {
    halamanAktif.value = 1
}

const halamanSebelumnya = () => {
    if (halamanAktif.value > 1) {
        halamanAktif.value--
    }
}

const halamanBerikutnya = () => {
    if (halamanAktif.value < totalHalaman.value) {
        halamanAktif.value++
    }
}
</script>

<template>
    <div class="space-y-6">

        <!-- TABEL KARTU UTANG -->
        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-6">

            <!-- FILTER -->
            <div class="mb-7 flex flex-col justify-between gap-4 xl:flex-row xl:items-center">

                <div class="flex flex-wrap items-center gap-3">

                    <!-- MODE -->
                    <div class="flex rounded-xl border border-slate-200 bg-slate-100 p-1">
                        <button
                            type="button"
                            @click="pilihMode('supplier')"
                            class="rounded-lg px-4 py-2.5 text-sm font-semibold transition"
                            :class="modeTampilan === 'supplier'
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'text-slate-600 hover:text-slate-800'"
                        >
                            Per Supplier
                        </button>

                        <button
                            type="button"
                            @click="pilihMode('semua')"
                            class="rounded-lg px-4 py-2.5 text-sm font-semibold transition"
                            :class="modeTampilan === 'semua'
                                ? 'bg-emerald-600 text-white shadow-sm'
                                : 'text-slate-600 hover:text-slate-800'"
                        >
                            Semua Supplier
                        </button>
                    </div>

                    <!-- PILIH SUPPLIER -->
                    <div
                        v-if="modeTampilan === 'supplier'"
                        class="relative min-w-[250px]"
                    >
                        <select
                            v-model="supplierTerpilih"
                            @change="pilihSupplier"
                            class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-3 pl-4 pr-10 text-sm text-slate-700 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        >
                            <option
                                v-for="item in suppliers"
                                :key="item.kode"
                                :value="item.kode"
                            >
                                {{ item.kode }} — {{ item.nama }}
                            </option>
                        </select>

                        <ChevronDown
                            :size="17"
                            class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400"
                        />
                    </div>

                    <div
                        v-else
                        class="flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
                    >
                        {{ suppliers.length }} Supplier ditampilkan
                    </div>
                </div>

                <!-- PILIH BULAN -->
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="gantiBulan(-1)"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50"
                    >
                        <ChevronLeft :size="19" />
                    </button>

                    <div class="flex h-11 min-w-[180px] items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 text-sm font-semibold capitalize text-slate-800">
                        <CalendarDays :size="16" class="text-slate-400" />
                        {{ namaBulan }}
                    </div>

                    <button
                        type="button"
                        @click="gantiBulan(1)"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50"
                    >
                        <ChevronRight :size="19" />
                    </button>
                </div>
            </div>

            <!-- TABEL -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left text-slate-500">
                            <th class="px-4 py-4 font-medium">Tanggal</th>

                            <th
                                v-if="modeTampilan === 'semua'"
                                class="px-4 py-4 font-medium"
                            >
                                Supplier
                            </th>

                            <th class="px-4 py-4 font-medium">No. Bukti</th>
                            <th class="px-4 py-4 font-medium">Keterangan</th>
                            <th class="px-4 py-4 text-right font-medium">Utang Masuk</th>
                            <th class="px-4 py-4 text-right font-medium">Dibayar</th>
                            <th class="px-4 py-4 text-right font-medium">Utang Aktif</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(item, index) in dataHalaman"
                            :key="`${item.supplier ?? 'total'}-${item.tipe}-${index}`"
                            :class="[
                                'border-b border-slate-100 transition',
                                item.tipe === 'total'
                                    ? 'bg-slate-50 font-semibold'
                                    : item.tipe === 'awal'
                                        ? 'bg-white'
                                        : 'hover:bg-slate-50/70'
                            ]"
                        >
                            <td class="whitespace-nowrap px-4 py-5 text-slate-600">
                                {{ item.tanggal }}
                            </td>

                            <td
                                v-if="modeTampilan === 'semua'"
                                class="min-w-[190px] px-4 py-5"
                            >
                                <template v-if="item.supplier">
                                    <p class="font-medium text-slate-800">
                                        {{ suppliers.find(s => s.kode === item.supplier)?.nama }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ item.supplier }}
                                    </p>
                                </template>
                            </td>

                            <td class="whitespace-nowrap px-4 py-5">
                                <span
                                    v-if="item.bukti"
                                    class="font-medium text-emerald-600"
                                >
                                    {{ item.bukti }}
                                </span>
                            </td>

                            <td class="px-4 py-5">
                                <p class="font-medium text-slate-800">
                                    {{ item.keterangan }}
                                </p>
                                <p
                                    v-if="item.subKeterangan"
                                    class="mt-1 text-xs text-slate-500"
                                >
                                    {{ item.subKeterangan }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right text-slate-600">
                                {{
                                    item.masuk === null
                                        ? ''
                                        : item.masuk
                                            ? formatRupiah(item.masuk)
                                            : '—'
                                }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right text-slate-600">
                                {{
                                    item.dibayar === null
                                        ? ''
                                        : item.dibayar
                                            ? formatRupiah(item.dibayar)
                                            : '—'
                                }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-5 text-right font-medium text-slate-900">
                                {{ formatRupiah(item.aktif) }}
                            </td>
                        </tr>

                        <tr v-if="dataHalaman.length === 0">
                            <td
                                :colspan="modeTampilan === 'semua' ? 7 : 6"
                                class="px-4 py-12 text-center text-sm text-slate-400"
                            >
                                Belum ada transaksi utang pada bulan ini.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- FOOTER -->
            <div class="mt-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                    <span>Tampilkan</span>

                    <select
                        v-model.number="jumlahPerHalaman"
                        @change="halamanAktif = 1"
                        class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 outline-none focus:border-emerald-500"
                    >
                        <option :value="10">10</option>
                        <option :value="25">25</option>
                        <option :value="50">50</option>
                        <option :value="100">100</option>
                    </select>

                    <span>per halaman</span>
                    <span class="text-slate-300">·</span>

                    <span>
                        Menampilkan {{ dataMulai }}–{{ dataSampai }}
                        dari {{ totalData }} data
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="halamanSebelumnya"
                        :disabled="halamanAktif === 1"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronLeft :size="18" />
                    </button>

                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-sm font-semibold text-white"
                    >
                        {{ halamanAktif }}
                    </button>

                    <button
                        type="button"
                        @click="halamanBerikutnya"
                        :disabled="halamanAktif >= totalHalaman"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-500 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
                    >
                        <ChevronRight :size="18" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
