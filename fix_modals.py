import re

file_path = 'd:/Coding/Gym-desk/resources/views/gym/members/index.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    text = f.read()

parts = text.split('<!-- Add Modal -->')
if len(parts) < 2:
    print("Add modal not found.")
    exit(1)

pre_modal = parts[0]
modal_content = '<!-- Add Modal -->' + parts[1]

replacements = [
    (r'\bbg-white\b', 'bg-white dark:bg-zinc-900'),
    (r'\btext-gray-900\b', 'text-zinc-900 dark:text-zinc-100'),
    (r'\btext-black\b', 'text-black dark:text-white'),
    (r'\bbg-black\b', 'bg-black dark:bg-zinc-950'),
    (r'\btext-gray-800\b', 'text-zinc-800 dark:text-zinc-200'),
    (r'\btext-gray-700\b', 'text-zinc-700 dark:text-zinc-300'),
    (r'\btext-gray-600\b', 'text-zinc-600 dark:text-zinc-400'),
    (r'\btext-gray-500\b', 'text-zinc-500 dark:text-zinc-400'),
    (r'\btext-gray-400\b', 'text-zinc-400 dark:text-zinc-500'),
    (r'\bbg-gray-500 bg-opacity-75\b', 'bg-black/60'),
    (r'\bbg-gray-900 bg-opacity-75\b', 'bg-black/80'),
    (r'\bbg-gray-100\b', 'bg-zinc-100 dark:bg-zinc-800'),
    (r'\bbg-gray-50\b', 'bg-zinc-50 dark:bg-zinc-800/50'),
    (r'\bborder-gray-300\b', 'border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100'),
    (r'\bborder-gray-200\b', 'border-zinc-200 dark:border-zinc-700'),
    (r'\bborder-gray-100\b', 'border-zinc-100 dark:border-zinc-800/80'),
    (r'\btext-primary\b', 'text-red-500'),
    (r'\bbg-primary\b', 'bg-red-600'),
    (r'\bhover:bg-blue-800\b', 'hover:bg-red-700'),
    (r'\bfocus:border-primary\b', 'focus:border-red-500'),
    (r'\bfocus:ring-primary\b', 'focus:ring-red-500'),
    (r'\bbg-blue-50\b', 'bg-red-50 dark:bg-red-900/30'),
    (r'\btext-blue-600\b', 'text-red-600 dark:text-red-400'),
    (r'\bhover:file:bg-blue-100\b', 'hover:file:bg-red-100 dark:hover:file:bg-red-900/50'),
    (r'\btext-blue-100\b', 'text-red-100 dark:text-red-200'),
    (r'\bbg-blue-100\b', 'bg-red-100 dark:bg-red-900/50'),
    (r'\btext-purple-600\b', 'text-purple-600 dark:text-purple-400'),
    (r'\btext-indigo-600\b', 'text-indigo-600 dark:text-indigo-400'),
    (r'\btext-indigo-500\b', 'text-indigo-500 dark:text-indigo-400'),
    (r'\bborder-white\b', 'border-white dark:border-zinc-800'),
    (r'\bbg-gray-900\b', 'bg-zinc-900 dark:bg-black'),
]

for old, new in replacements:
    modal_content = re.sub(old, new, modal_content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(pre_modal + modal_content)

print("Replaced modal content!")
