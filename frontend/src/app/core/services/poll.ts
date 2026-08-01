import { Service, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../../environments/environment';
import { Poll, PollPayload } from '../models/poll.model';

interface PollCollectionResponse {
  data: Poll[];
}

interface PollResponse {
  data: Poll;
}

@Service()
export class PollService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = `${environment.apiUrl}/polls`;

  list() {
    return this.http.get<PollCollectionResponse>(this.baseUrl);
  }

  get(id: number) {
    return this.http.get<PollResponse>(`${this.baseUrl}/${id}`);
  }

  create(payload: PollPayload) {
    return this.http.post<PollResponse>(this.baseUrl, payload);
  }

  update(id: number, payload: Omit<PollPayload, 'options'>) {
    return this.http.put<PollResponse>(`${this.baseUrl}/${id}`, payload);
  }

  remove(id: number) {
    return this.http.delete<void>(`${this.baseUrl}/${id}`);
  }

  vote(pollId: number, optionId: number) {
    return this.http.post<PollResponse>(`${this.baseUrl}/${pollId}/vote`, {
      option_id: optionId,
    });
  }
}
