export type PollStatus = 'não iniciada' | 'em andamento' | 'finalizada';

export interface PollOption {
  id: number;
  option_text: string;
  votes: number;
  percentage: number;
}

export interface Poll {
  id: number;
  title: string;
  start_date: string;
  end_date: string;
  status: PollStatus;
  voted_option_id: number | null;
  options: PollOption[];
}

export interface PollPayload {
  title: string;
  start_date: string;
  end_date: string;
  options?: string[];
}
