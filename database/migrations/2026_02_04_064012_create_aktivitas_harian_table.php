Schema::create('aktivitas_harian', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();

    $table->date('tanggal');
    $table->time('jam_mulai');
    $table->time('jam_selesai');

    $table->string('kegiatan', 255);
    $table->text('uraian')->nullable();

    $table->enum('status', ['draft','diajukan','disetujui','ditolak'])->default('draft');
    $table->foreignId('atasan_id')->nullable()->constrained('users');

    $table->timestamps();

    $table->index(['user_id','tanggal']);
});
