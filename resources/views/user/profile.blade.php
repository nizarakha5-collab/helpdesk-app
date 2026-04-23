@extends('user.layouts.tickets')

@section('title', 'Mon profil')
@section('topbar_title', 'Profil')
@section('top_button_text', 'Tableau de bord')
@section('top_button_link', route('user.dashboard'))

@section('content')
    <style>
        .profile-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e8edf5;
            box-shadow: 0 8px 26px rgba(31, 42, 68, 0.04);
            padding: 22px;
        }

        .profile-title {
            font-size: 2rem;
            font-weight: 800;
            color: #23345d;
            margin-bottom: 16px;
        }

        .profile-success-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #eaf8ee;
            color: #166534;
            border: 1px solid #bde7c9;
            font-size: .94rem;
        }

        .profile-error-message {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fff1f1;
            color: #b42318;
            border: 1px solid #f3c3c3;
            font-size: .94rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 14px;
        }

        .profile-field label {
            font-weight: 800;
            color: #23345d;
            font-size: .92rem;
        }

        .profile-field input,
        .profile-field select {
            height: 44px;
            border: 1px solid #d7dfec;
            border-radius: 12px;
            padding: 0 12px;
            font-size: .95rem;
            outline: none;
            background: #fff;
        }

        .profile-field input[type="file"] {
            height: auto;
            padding: 10px;
        }

        .profile-row {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .profile-avatar-box {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            border: 1px dashed #d7dfec;
            background: #f8fbff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-btn {
            height: 46px;
            border-radius: 12px;
            border: none;
            padding: 0 18px;
            font-weight: 800;
            cursor: pointer;
            background: #2f89d9;
            color: #fff;
        }

        .profile-muted {
            color: #7b88a5;
            font-size: .92rem;
            line-height: 1.6;
        }

        @media(max-width:1000px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-row {
                flex-direction: column;
            }
        }
    </style>

    <div class="profile-card">
        <div class="profile-title">Mon profil</div>

        @if (session('success'))
            <div class="profile-success-message">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="profile-error-message">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="profile-row" style="margin-bottom:18px;">
                <div class="profile-avatar-box">
                    @if ($user->avatar_path)
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar">
                    @else
                        <span class="profile-muted">No photo</span>
                    @endif
                </div>

                <div style="flex:1;">
                    <div class="profile-field">
                        <label>Photo / Avatar</label>
                        <input type="file" name="avatar" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-field">
                    <label>Full Name</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="profile-field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="profile-field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="06...">
                </div>

                <div class="profile-field">
                    <label>Type</label>
                    <select name="type" id="userType" required>
                        <option value="">-- Choisir --</option>
                        <option value="etudiant" {{ old('type', $user->type) === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                        <option value="prof" {{ old('type', $user->type) === 'prof' ? 'selected' : '' }}>Prof</option>
                        <option value="scolarite" {{ old('type', $user->type) === 'scolarite' ? 'selected' : '' }}>Scolarité</option>
                    </select>
                </div>

                <div class="profile-field">
                    <label>CIN</label>
                    <input type="text" name="cin" value="{{ old('cin', $user->cin) }}">
                </div>

                <div class="profile-field">
                    <label>Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance', $user->date_naissance?->format('Y-m-d')) }}">
                </div>
            </div>

            <div id="studentFields" style="margin-top:10px;display:none;">
                <div class="profile-grid">
                    <div class="profile-field">
                        <label>Filière (Étudiant)</label>
                        <input type="text" name="filiere" value="{{ old('filiere', $user->filiere) }}">
                    </div>

                    <div class="profile-field">
                        <label>Année (Étudiant)</label>
                        <select name="annee" id="studentYear">
                            <option value="">-- Choisir --</option>
                            <option value="1ere_annee" {{ old('annee', $user->annee) === '1ere_annee' ? 'selected' : '' }}>1ère année</option>
                            <option value="2eme_annee" {{ old('annee', $user->annee) === '2eme_annee' ? 'selected' : '' }}>2ème année</option>
                            <option value="licence" {{ old('annee', $user->annee) === 'licence' ? 'selected' : '' }}>Licence</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="profFields" style="margin-top:10px;display:none;">
                <div class="profile-grid">
                    <div class="profile-field">
                        <label>Département (Prof)</label>
                        <input type="text" name="departement" value="{{ old('departement', $user->departement) }}">
                    </div>
                    <div></div>
                </div>
            </div>

            <div style="margin-top:18px;">
                <button class="profile-btn" type="submit">Save Profile</button>
            </div>
        </form>
    </div>

    <script>
        const typeSelect = document.getElementById('userType');
        const studentFields = document.getElementById('studentFields');
        const profFields = document.getElementById('profFields');

        function toggleFields() {
            const v = typeSelect.value;
            studentFields.style.display = (v === 'etudiant') ? 'block' : 'none';
            profFields.style.display = (v === 'prof') ? 'block' : 'none';
        }

        toggleFields();
        typeSelect.addEventListener('change', toggleFields);
    </script>
@endsection