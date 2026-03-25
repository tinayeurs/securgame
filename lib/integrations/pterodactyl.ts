export type ServerStatus = {
  state: "running" | "stopped" | "installing" | "unknown";
  cpu: number;
  memoryMb: number;
};

export interface PanelClient {
  testConnection(input: { baseUrl: string; apiKey: string }): Promise<{ ok: boolean; message: string }>;
  getServerStatus(serviceId: string): Promise<ServerStatus>;
}

class MockPanelClient implements PanelClient {
  async testConnection() {
    return { ok: true, message: "Mode mock: panel non configuré, test simulé." };
  }

  async getServerStatus(serviceId: string) {
    const seed = Number(serviceId) || 1;
    return {
      state: seed % 2 === 0 ? "running" : "stopped",
      cpu: 18 + seed,
      memoryMb: 2048 + seed * 100
    };
  }
}

export async function getServerPanelClient(): Promise<PanelClient> {
  return new MockPanelClient();
}
