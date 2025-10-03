<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSearch extends Component
{
    use WithPagination;

    #[Url(keep: true)] public string $q = '';
    #[Url(keep: true)] public string $category = '';
    #[Url(keep: true)] public string $grader = '';
    #[Url(keep: true)] public string $grade = '';
    #[Url(keep: true)] public string $set_name = '';
    #[Url(keep: true)] public string $release_year = '';
    #[Url(keep: true)] public string $edition = '';
    #[Url(keep: true)] public string $rarity = '';
    #[Url(keep: true)] public string $holofoil_type = '';
    #[Url(keep: true)] public string $art_style = '';
    #[Url(keep: true)] public string $language = '';
    #[Url(keep: true)] public $min_price = null;
    #[Url(keep: true)] public $max_price = null;

    public array $graders = [];
    public array $grades = [];
    public array $categories = [];
    public array $set_names = [];
    public array $release_years = [];
    public array $editions = [];
    public array $rarities = [];
    public array $holofoil_types = [];
    public array $art_styles = [];
    public array $languages = [];
    public float $global_min_price = 0;
    public float $global_max_price = 0;

    public function mount(): void
    {
        $this->loadFilterOptions();
        
        $this->global_min_price = (float)(Product::min('price') ?? 0);
        $this->global_max_price = (float)(Product::max('price') ?? 0);
        $this->min_price ??= $this->global_min_price;
        $this->max_price ??= $this->global_max_price;
    }

    protected function loadFilterOptions(): void
    {
        $this->categories     = $this->categoryOptions();
        $this->graders        = $this->distinct('grader');
        $this->grades         = $this->distinct('grade', true);
        $this->set_names      = $this->distinct('set_name');
        $this->release_years  = $this->distinct('release_year', true);
        $this->editions       = $this->distinct('edition');
        $this->rarities       = $this->distinct('rarity');
        $this->holofoil_types = $this->distinct('holofoil_type');
        $this->art_styles     = $this->distinct('art_style');
        $this->languages      = $this->distinct('language');
    }    protected function distinct(string $col, bool $numeric = false): array
    {
        $vals = Product::whereNotNull($col)->distinct()->pluck($col)
            ->filter(fn($v)=>trim($v)!=='')->values()->toArray();
        $numeric ? sort($vals, SORT_NUMERIC)
                 : sort($vals, SORT_NATURAL|SORT_FLAG_CASE);
        return $vals;
    }

    protected function categoryOptions(): array
    {
        return \App\Models\ProductCategory::orderBy('name')
            ->get(['id','name'])
            ->map(fn($c)=>['id'=>$c->id,'name'=>$c->name])
            ->toArray();
    }

    public function updatedQ(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedGrader(): void
    {
        $this->resetPage();
    }

    public function updatedGrade(): void
    {
        $this->resetPage();
    }

    public function updatedSetName(): void
    {
        $this->resetPage();
    }

    public function updatedReleaseYear(): void
    {
        $this->resetPage();
    }

    public function updatedEdition(): void
    {
        $this->resetPage();
    }

    public function updatedRarity(): void
    {
        $this->resetPage();
    }

    public function updatedHolofoilType(): void
    {
        $this->resetPage();
    }

    public function updatedArtStyle(): void
    {
        $this->resetPage();
    }

    public function updatedLanguage(): void
    {
        $this->resetPage();
    }

    public function updatedMinPrice(): void
    {
        $this->resetPage();
    }

    public function updatedMaxPrice(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'q','category','grader','grade','set_name','release_year','edition',
            'rarity','holofoil_type','art_style','language'
        ]);
        $this->min_price = $this->global_min_price;
        $this->max_price = $this->global_max_price;
        $this->resetPage();
    }

    #[Computed]
    public function products()
    {
        $q = Product::query();

        if ($this->q !== '') {
            $term = '%'.$this->q.'%';
            $q->where(function($s) use ($term){
                $s->where('pokemon_name','like',$term)
                  ->orWhere('card_name','like',$term);
            });
        }
    // Explicitly reference each filter so Livewire's computed dependency tracking sees them
    if ($this->category !== '')      { $q->where('category_id', $this->category); }
    if ($this->grader   !== '')      { $q->where('grader', $this->grader); }
    if ($this->grade    !== '')      { $q->where('grade', $this->grade); }
    if ($this->set_name !== '')      { $q->where('set_name', $this->set_name); }
    if ($this->release_year !== '')  { $q->where('release_year', $this->release_year); }
    if ($this->edition  !== '')      { $q->where('edition', $this->edition); }
    if ($this->rarity   !== '')      { $q->where('rarity', $this->rarity); }
    if ($this->holofoil_type !== '') { $q->where('holofoil_type', $this->holofoil_type); }
    if ($this->art_style !== '')     { $q->where('art_style', $this->art_style); }
    if ($this->language !== '')      { $q->where('language', $this->language); }

        if($this->min_price!==null) $q->where('price','>=',(float)$this->min_price);
        if($this->max_price!==null) $q->where('price','<=',(float)$this->max_price);

        return $q->orderByDesc('created_at')->paginate(12);
    }

    public function render()
    {
        return view('livewire.product-search', [
            'products' => $this->products,
        ]);
    }
}