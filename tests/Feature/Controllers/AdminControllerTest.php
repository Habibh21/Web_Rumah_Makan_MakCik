<?php

// KODE YANG BERUBAH: Menambahkan \Controllers di akhir baris ini
namespace Tests\Feature\Controllers; 

use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Reservasi;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminControllerTest extends TestCase
{
    use DatabaseTransactions; 

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::firstOrCreate(
            ['email' => 'admin@makcik.com'],
            ['name' => 'Admin Mak Cik', 'password' => bcrypt('13')]
        );
    }

    public function test_halaman_dashboard_tampil_dengan_data_yang_benar()
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('admin_dashboard'); 
        $response->assertViewHasAll(['totalMenu', 'totalReservasi', 'reservasiHariIni']);
    }

    public function test_halaman_daftar_menu_bisa_dibuka()
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin');
        $response->assertViewHas('menus');
    }

    public function test_halaman_form_tambah_menu_bisa_dibuka()
    {
        $response = $this->actingAs($this->admin)->get('/admin/create');

        $response->assertStatus(200);
        $response->assertViewIs('admin_create');
    }

    public function test_admin_bisa_menyimpan_menu_baru_beserta_foto()
    {
        $fotoPalsu = UploadedFile::fake()->create('ayam-bakar-test.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post('/admin/store', [
            'kategori' => 'Makanan',
            'nama' => 'Ayam Bakar Testing',
            'harga' => '18K',
            'gambar' => $fotoPalsu,
        ]);

        $response->assertRedirect('/admin');
        $response->assertSessionHas('success', 'Menu berhasil ditambahkan!');

        $this->assertDatabaseHas('menus', [
            'kategori' => 'Makanan',
            'nama' => 'Ayam Bakar Testing',
            'harga' => '18K',
        ]);
    }

    public function test_halaman_edit_menu_bisa_dibuka()
    {
        $menu = Menu::create([
            'kategori' => 'Minuman',
            'nama' => 'Es Teh Testing',
            'harga' => '5K'
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/edit/' . $menu->id);

        $response->assertStatus(200);
        $response->assertViewIs('admin_edit');
        $response->assertViewHas('menu');
    }

    public function test_admin_bisa_mengubah_data_menu()
    {
        $menu = Menu::create([
            'kategori' => 'Minuman',
            'nama' => 'Es Jeruk',
            'harga' => '6K'
        ]);

        $response = $this->actingAs($this->admin)->put('/admin/update/' . $menu->id, [
            'kategori' => 'Minuman',
            'nama' => 'Es Jeruk Manis', 
            'harga' => '8K', 
        ]);

        $response->assertRedirect('/admin');
        $response->assertSessionHas('success', 'Menu berhasil diperbarui!');

        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'nama' => 'Es Jeruk Manis',
            'harga' => '8K',
        ]);
    }

    public function test_admin_bisa_menghapus_menu()
    {
        $menu = Menu::create([
            'kategori' => 'Makanan',
            'nama' => 'Menu Siap Dihapus',
            'harga' => '10K'
        ]);

        $response = $this->actingAs($this->admin)->delete('/admin/destroy/' . $menu->id);

        $response->assertRedirect('/admin');
        $response->assertSessionHas('success', 'Menu berhasil dihapus!');

        $this->assertDatabaseMissing('menus', [
            'id' => $menu->id,
        ]);
    }

    public function test_halaman_daftar_reservasi_bisa_dibuka()
    {
        Reservasi::create([
            'nama' => 'Budi Testing',
            'jumlah_orang' => 4,
            'tanggal' => '2026-05-01',
            'waktu' => '19:00',
            'no_hp' => '08123456789'
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/reservasi');

        $response->assertStatus(200);
        $response->assertViewIs('admin_reservasi');
        $response->assertViewHas('reservasis');
    }
}