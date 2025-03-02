<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Data akun utama (Accounts)
        $accounts = [
            ['kode' => '1000', 'name' => 'Aset', 'status' => '__ON__'],
            ['kode' => '2000', 'name' => 'Kewajiban (Liabilitas)', 'status' => '__ON__'],
            ['kode' => '3000', 'name' => 'Ekuitas', 'status' => '__ON__'],
            ['kode' => '4000', 'name' => 'Pendapatan', 'status' => '__ON__'],
            ['kode' => '5000', 'name' => 'Biaya', 'status' => '__ON__'],
            ['kode' => '6000', 'name' => 'Lain - lain', 'status' => '__ON__'],
        ];

        // Insert ke tabel accounts
        foreach ($accounts as $account) {
            $account['created_at'] = $now;
            $account['updated_at'] = $now;
            $account_id = DB::table('accounts')->insertGetId($account);

            // Data akun sub (Account Subs)
            $subAccounts = [];

            switch ($account['kode']) {
                case '1000': // Aset
                    $subAccounts = [
                        ['kode' => '1010', 'name' => 'Kas', 'keterangan' => 'Saldo tunai'],
                        ['kode' => '1020', 'name' => 'Bank', 'keterangan' => 'Saldo di rekening bank syariah'],
                        ['kode' => '1030', 'name' => 'Aset Tetap', 'keterangan' => 'Tanah, kendaraan, peralatan'],
                        ['kode' => '1040', 'name' => 'Dana Wakaf', 'keterangan' => 'Dana wakaf yang tidak boleh digunakan selain untuk kepentingan wakafnya'],
                    ];
                    break;

                case '2000': // Kewajiban
                    $subAccounts = [
                        ['kode' => '2010', 'name' => 'Mukafa\'ah', 'keterangan' => 'Gaji dan tunjangan staf yayasan'],
                        ['kode' => '2020', 'name' => 'Program Jumber', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2030', 'name' => 'Program Sembako', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2040', 'name' => 'Program Ambulan', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2050', 'name' => 'Program Khitan', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2060', 'name' => 'Program Kifayah', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2070', 'name' => 'Program Sosial Dakwah', 'keterangan' => 'Biaya kegiatan sosial dan bantuan ke masyarakat'],
                        ['kode' => '2080', 'name' => 'Sewa Kantor', 'keterangan' => 'Kewajiban pembayaran sewa gedung atau fasilitas'],
                    ];
                    break;

                case '3000': // Ekuitas
                    $subAccounts = [
                        ['kode' => '3010', 'name' => 'Dana Yayasan', 'keterangan' => 'Dana awal yayasan'],
                        ['kode' => '3020', 'name' => 'Dana Infaq', 'keterangan' => 'Dana yang bisa digunakan untuk sosial'],
                        ['kode' => '3030', 'name' => 'Dana Sedekah', 'keterangan' => 'Dana khusus dari sedekah yang bisa digunakan untuk berbagai program sosial'],
                        ['kode' => '3040', 'name' => 'Dana Hibah', 'keterangan' => 'Dana hibah dari lembaga atau donatur'],
                        ['kode' => '3050', 'name' => 'Dana Wakaf', 'keterangan' => 'Dana wakaf yang tidak boleh dipakai selain wakaf'],
                        ['kode' => '3060', 'name' => 'Surplus / Defisit Periode Berjalan', 'keterangan' => 'Laba atau rugi dari operasional yayasan'],
                    ];
                    break;

                case '4000': // Pendapatan
                    $subAccounts = [
                        ['kode' => '4010', 'name' => 'Donasi PA/KA', 'keterangan' => 'Donasi dalam bentuk Pundi Amal dan Kotak Amal'],
                        ['kode' => '4020', 'name' => 'Donasi Tunai', 'keterangan' => 'Donasi dalam bentuk uang tunai'],
                        ['kode' => '4030', 'name' => 'Donasi Barang', 'keterangan' => 'Donasi dalam bentuk barang'],
                        ['kode' => '4040', 'name' => 'Hibah Pemerintah', 'keterangan' => 'Bantuan dari pemerintah atau lembaga resmi'],
                        ['kode' => '4050', 'name' => 'Pendapatan Program Sosial', 'keterangan' => 'Dana dari program berbasis sosial'],
                        ['kode' => '4060', 'name' => 'Pendapatan Investasi Halal', 'keterangan' => 'Pendapatan dari investasi yang sesuai syariah (misalnya mudharabah)'],
                    ];
                    break;

                case '5000': // Biaya
                    $subAccounts = [
                        ['kode' => '5010', 'name' => 'Biaya Operasional', 'keterangan' => 'Biaya umum operasional yayasan'],
                        ['kode' => '5020', 'name' => 'Biaya Listrik, Air, dan Internet', 'keterangan' => 'Biaya utilitas kantor yayasan'],
                        ['kode' => '5030', 'name' => 'Biaya Transportasi', 'keterangan' => 'Biaya perjalanan atau pengiriman bantuan'],
                        ['kode' => '5040', 'name' => 'Biaya Administrasi dan Umum', 'keterangan' => 'Biaya perlengkapan kantor, ATK, dll.'],
                    ];
                    break;

                case '6000': // Lain - lain
                    $subAccounts = [
                        ['kode' => '6010', 'name' => 'Pendapatan Lain-Lain', 'keterangan' => 'Pendapatan di luar kegiatan utama yayasan.'],
                        ['kode' => '6020', 'name' => 'Pengeluaran Lain-Lain', 'keterangan' => 'Pengeluaran di luar kegiatan utama yayasan.'],
                    ];
                    break;
            }

            // Insert ke tabel account_subs
            foreach ($subAccounts as $sub) {
                $sub['account_id'] = $account_id;
                $sub['created_at'] = $now;
                $sub['updated_at'] = $now;
                DB::table('account_subs')->insert($sub);
            }
        }
    }
}
