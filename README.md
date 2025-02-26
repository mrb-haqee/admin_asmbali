## Requirements

1. NPM
2. Composer
3. PHP > 8.2

## First time setup

1. Run 'npm install'
2. Run 'composer install'
3. Run 'npm run dev'
4. Run 'php artisan key:generate'
5. Run 'php artisan migrate --seed'

## Run the system

6. Run 'php artisan serve'

# Library

## Penamaan File yang baik

 - Index: untuk file awal
 - Daftar: untuk file Data daftar
 - Form: untuk file Form modal

## Types Commit

-   API or UI relevant changes
    -   `feat` Commits, that add or remove a new feature to the API or UI
    -   `fix` Commits, that fix a API or UI bug of a preceded `feat` commit
-   `refactor` Commits, that rewrite/restructure your code, however do not change any API or UI behaviour
    -   `perf` Commits are special `refactor` commits, that improve performance
-   `style` Commits, that do not affect the meaning (white-space, formatting, missing semi-colons, etc)
-   `test` Commits, that add missing tests or correcting existing tests
-   `docs` Commits, that affect documentation only
-   `build` Commits, that affect build components like build tool, ci pipeline, dependencies, project version, ...
-   `ops` Commits, that affect operational components like infrastructure, deployment, backup, recovery, ...
-   `chore` Miscellaneous commits e.g. modifying `.gitignore`


## Livewire

| Atribut        | Fungsi | Contoh Penggunaan |
|---------------|--------|------------------|
| `#[On]` | Mendengarkan event Livewire | `#[On('modal.show.role_name')] public function mountRole($role) { ... }` |
| `#[Computed]` | Menjadikan metode sebagai properti yang dihitung ulang | `#[Computed] public function fullName() { return $this->first . ' ' . $this->last; }` |
| `#[Locked]` | Mencegah properti diubah dari frontend | `#[Locked] public string $status = 'pending';` |
| `#[Reactive]` | Menyinkronkan properti dengan frontend | `#[Reactive] public $search;` |
| `#[Modelable]` | Memungkinkan binding dua arah dengan `wire:model` | `#[Modelable] public string $email = '';` |
| `#[Url]` | Menghubungkan properti dengan query string di URL | `#[Url] public string $search = '';` |
| `#[Rule]` | Menetapkan aturan validasi langsung dalam properti | `#[Rule('required\|min:3')] public string $name;` |
| `#[LockedArray]` | Mencegah frontend mengubah struktur array | `#[LockedArray] public array $settings = ['theme' => 'dark'];` |
| `#[Persist]` | Menyimpan nilai properti ke sesi agar tetap ada setelah refresh | `#[Persist] public int $counter = 0;` |


 <select id="group" class="form-select form-control-solid mb-3 mb-lg-0" wire:model.defer="group"
    data-control="select2" data-placeholder="Select an option" data-allow-clear="true"
    data-hide-search="true"
    onchange="@this.set('group', Array.from(this.selectedOptions).map(option => option.value))" multiple>
    <option></option>
    <option value="konfigurasi">Konfigurasi</option>
    <option value="administrasi">Administrasi</option>
    <option value="web_asm">Web ASM</option>
    <option value="web_tpq">Web TPQ</option>
</select>

<select id="group" class="form-select form-control-solid mb-3 mb-lg-0" wire:model.defer="group"
    data-control="select2" data-placeholder="Select an option" data-allow-clear="true"
    data-hide-search="true" onchange="@this.set('group', this.value)">
    <option></option>
    <option value="konfigurasi">Konfigurasi</option>
    <option value="administrasi">Administrasi</option>
    <option value="web_asm">Web ASM</option>
    <option value="web_tpq">Web TPQ</option>
</select>

