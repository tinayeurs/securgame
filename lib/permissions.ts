import { AppRole } from "@/lib/auth";

const hierarchy: Record<AppRole, number> = {
  CLIENT: 1,
  STAFF: 2,
  ADMIN: 3
};

export function canAccess(userRole: AppRole, minimumRole: AppRole) {
  return hierarchy[userRole] >= hierarchy[minimumRole];
}
