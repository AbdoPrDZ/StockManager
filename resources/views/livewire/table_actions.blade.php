<div class="d-flex gap-5">
  @isset ($viewLink)
    <a href="{{ $viewLink }}"><i class="fa-solid fa-eye me-2"></i></a>
  @endif

  @isset ($editLink)
    <a href="{{ $editLink }}"><i class="fa-solid fa-pen-to-square me-2"></i></a>
  @endif

  @isset ($deleteLink)
    <form
      action="{{ $deleteLink }}"
      class="d-inline"
      method="POST"
      x-data
      @submit.prevent="if (confirm('Are you sure you want to delete this user?')) $el.submit()"
    >
      @method('DELETE')
      @csrf
      <button type="submit" class="btn btn-link">
        <i class="fa-solid fa-trash"></i>
      </button>
    </form>
  @endif

  @isset($addToCart)
    <button class="btn btn-link" onclick="addToCart({{ $addToCart }})">
      <i class="fa-solid fa-cart-plus"></i>
    </button>
  @endif
</div>
