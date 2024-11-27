<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Bot</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bots.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="token" class="form-label">Bot Token</label>
                                <input type="text" 
                                       class="form-control @error('token') is-invalid @enderror" 
                                       id="token" 
                                       name="token" 
                                       value="{{ old('token') }}" 
                                       required>
                                <div class="form-text">Get this from @BotFather on Telegram</div>
                                @error('token')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Bot Name (Optional)</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}">
                                <div class="form-text">A friendly name to identify your bot</div>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Bot</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
