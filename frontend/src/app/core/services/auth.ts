import { Service, inject, signal, computed } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs';
import { environment } from '../../../environments/environment';
import { AuthResponse, User } from '../models/user.model';

const TOKEN_KEY = 'votacao_token';
const USER_KEY = 'votacao_user';

@Service()
export class AuthService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = environment.apiUrl;

  private readonly tokenSignal = signal<string | null>(localStorage.getItem(TOKEN_KEY));
  private readonly userSignal = signal<User | null>(this.readStoredUser());

  readonly isAuthenticated = computed(() => this.tokenSignal() !== null);
  readonly user = this.userSignal.asReadonly();

  token(): string | null {
    return this.tokenSignal();
  }

  login(email: string, password: string) {
    return this.http
      .post<AuthResponse>(`${this.baseUrl}/login`, { email, password })
      .pipe(tap((response) => this.persistSession(response)));
  }

  register(name: string, email: string, password: string, passwordConfirmation: string) {
    return this.http
      .post<AuthResponse>(`${this.baseUrl}/register`, {
        name,
        email,
        password,
        password_confirmation: passwordConfirmation,
      })
      .pipe(tap((response) => this.persistSession(response)));
  }

  logout() {
    return this.http.post<void>(`${this.baseUrl}/logout`, {}).pipe(tap(() => this.clearSession()));
  }

  clearSession(): void {
    localStorage.removeItem(TOKEN_KEY);
    localStorage.removeItem(USER_KEY);
    this.tokenSignal.set(null);
    this.userSignal.set(null);
  }

  private persistSession(response: AuthResponse): void {
    localStorage.setItem(TOKEN_KEY, response.token);
    localStorage.setItem(USER_KEY, JSON.stringify(response.user));
    this.tokenSignal.set(response.token);
    this.userSignal.set(response.user);
  }

  private readStoredUser(): User | null {
    const raw = localStorage.getItem(USER_KEY);
    return raw ? (JSON.parse(raw) as User) : null;
  }
}
