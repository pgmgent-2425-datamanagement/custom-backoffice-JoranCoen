<div class="flex flex-col gap-4 p-10 w-full bg-base-100">
    <h1 class="text-3xl font-semibold mb-4"><?= htmlspecialchars($title) ?></h1>

    <div class="px-4">
        <form action="/file-manager/upload" method="POST" enctype="multipart/form-data" class="space-y-2">
            <label for="file" class="block text-sm font-medium">Upload File</label>
            <input type="file" name="file" id="file" class="file-input file-input-bordered w-full max-w-xs">
            <button type="submit" name="upload" class="btn ">Upload</button>
        </form>
    </div>

    <div class="flex flex-wrap gap-4 px-4">
        <?php
        $upload_dir = __DIR__ . '/../public/uploads/';
        $files = scandir($upload_dir);

        $files = array_filter($files, fn($file) => $file !== '.' && $file !== '..');

        foreach ($files as $file):
            $file_path = $upload_dir . $file;
            $file_extension = pathinfo($file, PATHINFO_EXTENSION);
        ?>
            <div class="flex flex-col items-center">
                <?php if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($file) ?>" alt="<?= htmlspecialchars($file) ?>" class="max-w-[150px] h-auto mb-2">
                <?php elseif ($file_extension === 'pdf'): ?>
                    <embed src="/uploads/<?= htmlspecialchars($file) ?>" width="150" height="200px" type="application/pdf" class="mb-2">
                <?php elseif (in_array($file_extension, ['txt', 'md'])): ?>
                    <?php $file_content = file_get_contents($file_path); ?>
                    <pre class="bg-gray-100 p-2 text-xs max-w-[150px] mb-2"><?= htmlspecialchars(substr($file_content, 0, 100)) ?>...</pre>
                <?php endif; ?>

                <form action="/file-manager/delete" method="POST" class="mt-2">
                    <input type="hidden" name="file" value="<?= htmlspecialchars($file) ?>">
                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
