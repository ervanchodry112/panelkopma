<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MainTable extends Migration
{
    public function up()
    {
        // Create tabel fakultas
        $this->forge->addField([
            'id_fakultas' => [
                'type' => 'INT',
                'constraint' => 2,
                'auto_increment' => true,
            ],
            'nama_fakultas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_fakultas');
        $this->forge->createTable('fakultas');

        // Create table jurusan
        $this->forge->addField([
            'id_jurusan' => [
                'type' => 'INT',
                'constraint' => 2,
                'auto_increment' => true,
            ],
            'nama_jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_fakultas' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_jurusan');
        $this->forge->addForeignKey('id_fakultas', 'fakultas', 'id_fakultas', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jurusan');


        // Create table data_anggota
        $this->forge->addField([
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'npm' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type'  => 'VARCHAR',
                'constraint'    => 1,
            ],
            'status_keanggotaan' => [
                'type'  => 'VARCHAR',
                'constraint'    => 30,
            ],
            'tgl_diksar' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'id_jurusan' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('nomor_anggota');
        $this->forge->addUniqueKey('npm');
        $this->forge->addForeignKey('id_jurusan', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_anggota');

        // Create table data_simpanan
        $this->forge->addField([
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'simpanan_pokok' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'simpanan_wajib' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('nomor_anggota');
        $this->forge->addForeignKey('nomor_anggota', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_simpanan');

        // Create table data_poin
        $this->forge->addField([
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'poin' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('nomor_anggota');
        $this->forge->addForeignKey('nomor_anggota', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->createTable('data_poin');

        // Create table referal
        $this->forge->addField([
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'kode_referal' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('kode_referal');
        $this->forge->addForeignKey('nomor_anggota', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->createTable('referal');

        // Create tabel akun
        $this->forge->addField([
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('nomor_anggota');
        $this->forge->addForeignKey('nomor_anggota', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('akun');

        // Create tabel calon_anggota
        $this->forge->addField([
            'npm' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_jurusan' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'kode_referal' => [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'jenis_kelamin' => [
                'type' => 'VARCHAR',
                'constraint' => 1,
            ],
            'domisili' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alasan' => [
                'type' => 'TEXT',
            ],
            'asal_informasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_panggilan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ktm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'bukti_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('npm');
        $this->forge->addForeignKey('id_jurusan', 'jurusan', 'id_jurusan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kode_referal', 'referal', 'kode_referal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('calon_anggota');

        // Create table data_kegiatan
        $this->forge->addField([
            'id_kegiatan' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tempat_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_kegiatan' => [
                'type' => 'DATE',
            ],
            'link'  => [
                'type'  => 'VARCHAR',
                'constraint'    => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_kegiatan');
        $this->forge->createTable('data_kegiatan');

        // Create Tabel hasil_survey
        $this->forge->addField([
            'id_laporan' => [
                'type' => 'VARCHAR',
                'constraint' => 20,

            ],
            'nama_survey' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
            ],
            'jumlah_responden' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_laporan');
        $this->forge->createTable('hasil_survey');

        // Create tabel pembayaran_simwa
        $this->forge->addField([
            'id_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'timestamp' => [
                'type' => 'DATETIME',
            ],
            'nomor_anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nominal' => [
                'type' => 'INT',
                'constraint' => 6,
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'bukti_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_pembayaran');
        $this->forge->addForeignKey('nomor_anggota', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembayaran_simwa');

        // Create Tabel Presensi
        $this->forge->addField([
            'id_presensi' => [
                'type' => 'INT',
                'constraint' => 4,
                'auto_increment' => true,
            ],
            'waktu' => [
                'type' => 'DATETIME',
            ],
            'id_data' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'id_kegiatan' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id_presensi');
        $this->forge->addForeignKey('id_data', 'data_anggota', 'nomor_anggota', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kegiatan', 'data_kegiatan', 'id_kegiatan', 'CASCADE', 'CASCADE');
        $this->forge->createTable('presensi');
    }



    public function down()
    {
        //Drop all tables
        $this->forge->dropTable('pembayaran_simwa');
        $this->forge->dropTable('hasil_survey');
        $this->forge->dropTable('presensi');
        $this->forge->dropTable('data_kegiatan');
        $this->forge->dropTable('calon_anggota');
        $this->forge->dropTable('data_simpanan');
        $this->forge->dropTable('data_poin');
        $this->forge->dropTable('referal');
        $this->forge->dropTable('akun');
        $this->forge->dropTable('data_anggota');
        $this->forge->dropTable('jurusan');
        $this->forge->dropTable('fakultas');
    }
}
